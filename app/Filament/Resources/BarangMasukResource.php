<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangMasukResource\Pages;
use App\Models\BarangMasuk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangMasukResource extends Resource
{
    protected static ?string $model = BarangMasuk::class;

    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-tray';

    public static function getLabel(): string
    {
        return 'Barang Masuk';
    }

    public static function getPluralLabel(): string
    {
        return 'Barang Masuk';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Transaksi')
                ->schema([
                    Forms\Components\TextInput::make('no_transaksi')
                        ->label('No Transaksi')
                        ->default(fn() => 'T-BK-' . now()->format('Ymd') . rand(1000, 9999))
                        ->disabled()
                        ->dehydrated()
                        ->columnSpanFull(),

                    Forms\Components\DatePicker::make('tanggal')
                        ->label('Tanggal Masuk')
                        ->default(now())
                        ->required()
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Detail Barang')
                ->schema([
                    Forms\Components\Select::make('barang_id')
                        ->label('Nama Barang')
                        ->relationship('barang', 'nama_barang')
                        ->searchable()
                        ->required()
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('jumlah')
                        ->label('Jumlah Masuk')
                        ->numeric()
                        ->required()
                        ->minValue(1)
                        ->columnSpanFull(),

                    // ✅ Ubah dari relasi ke input manual
                    Forms\Components\TextInput::make('kategori')
                        ->label('Kategori')
                        ->placeholder('Contoh: Elektronik, Alat Tulis, dll')
                        ->required()
                        ->maxLength(100)
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Informasi User')
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->label('User')
                        ->relationship('user', 'name')
                        ->default(fn() => auth()->id())
                        ->searchable()
                        ->required()
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_transaksi')
                    ->label('No Transaksi')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('barang.nama_barang')
                    ->label('Nama Barang')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->sortable()
                    ->formatStateUsing(fn($state) => number_format($state, 0, ',', '.') . ' unit'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Petugas')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal Masuk')
                    ->date('d M Y')
                    ->sortable(),
            ])

            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->label('Filter Kategori')
                    ->options(function () {
                        // Ambil daftar kategori unik dari data barang masuk
                        return BarangMasuk::query()
                            ->select('kategori')
                            ->distinct()
                            ->pluck('kategori', 'kategori')
                            ->toArray();
                    }),
            ])

            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

                Tables\Actions\Action::make('print')
                    ->label('Cetak')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->form([
                        Forms\Components\TextInput::make('ket_cetak')
                            ->label('Barang digunakan untuk')
                            ->placeholder('Pemasangan / Pergantian / Pemeliharaan'),

                        Forms\Components\Textarea::make('desk_cetak')
                            ->label('Deskripsi Tambahan')
                            ->placeholder('Masukan deskripsi...'),

                        Forms\Components\FileUpload::make('foto_sebelum')
                            ->label('Foto Sebelum')
                            ->directory('lampiran-barang-masuk')
                            ->image()
                            ->preserveFilenames(),

                        Forms\Components\FileUpload::make('foto_sesudah')
                            ->label('Foto Sesudah')
                            ->directory('lampiran-barang-masuk')
                            ->image()
                            ->preserveFilenames(),

                        Forms\Components\FileUpload::make('foto_sebelum_2')
                            ->label('Foto Sebelum (Tambahan)')
                            ->directory('lampiran-barang-keluar')
                            ->image()
                            ->preserveFilenames(),

                        Forms\Components\FileUpload::make('foto_sesudah_2')
                            ->label('Foto Sesudah (Tambahan)')
                            ->directory('lampiran-barang-keluar')
                            ->image()
                            ->preserveFilenames(),

                    ])

                    ->action(function (BarangMasuk $record, array $data) {

                        // Resolver FILE PATH ABSOLUT
                        $resolve = function ($value) {

                            if (!$value) return null;

                            if (is_array($value) && isset($value[0]['path'])) {
                                $path = storage_path('app/public/' . $value[0]['path']);
                            } elseif (is_array($value) && isset($value['path'])) {
                                $path = storage_path('app/public/' . $value['path']);
                            } elseif (is_string($value)) {
                                $path = storage_path('app/public/' . $value);
                            } else {
                                return null;
                            }

                            $path = realpath($path);

                            if (!$path || !file_exists($path)) return null;

                            return $path;
                        };

                        $fotoSebelum = $resolve($data['foto_sebelum'] ?? null);
                        $fotoSesudah = $resolve($data['foto_sesudah'] ?? null);
                        $fotoSebelum2 = $resolve($data['foto_sebelum_2'] ?? null);
                        $fotoSesudah2 = $resolve($data['foto_sesudah_2'] ?? null);

                        $pdf = Pdf::loadView('pdf.barang-masuk-single', [
                            'record'        => $record,
                            'keterangan'    => $data['ket_cetak'] ?? '',
                            'deskripsi'     => $data['desk_cetak'] ?? '',
                            'foto_sebelum'  => $fotoSebelum,
                            'foto_sesudah'  => $fotoSesudah,
                            'foto_sebelum_2' => $fotoSebelum2,
                            'foto_sesudah_2' => $fotoSesudah2,
                        ])->setPaper('a4', 'landscape');

                        return response()->streamDownload(
                            fn() => print($pdf->output()),
                            "barang-masuk-{$record->no_transaksi}.pdf"
                        );
                    }),

            ])



            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),

                // Tables\Actions\BulkAction::make('print')
                //     ->label('Cetak Terpilih')
                //     ->icon('heroicon-o-printer')
                //     ->color('success')
                //     ->action(function (Collection $records) {
                //         $pdf = Pdf::loadHTML(view('pdf.barang-masuk-bulk', [
                //             'records' => $records,
                //             'tanggal' => now()->format('d F Y'),
                //         ]));
                //         return response()->streamDownload(
                //             fn() => print($pdf->output()),
                //             'laporan-barang-masuk.pdf'
                //         );
                //     }),
            ])

            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBarangMasuk::route('/'),
            'create' => Pages\CreateBarangMasuk::route('/create'),
            'edit' => Pages\EditBarangMasuk::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
