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
                            ->placeholder('Pemasangan / Pergantian'),

                        Forms\Components\Textarea::make('desk_cetak')
                            ->label('Deskripsi Tambahan')
                            ->placeholder('Masukan deskripsi...'),
                    ])

                    ->action(function (BarangMasuk $record, array $data) {
                        $pdf = Pdf::loadHTML(view('pdf.barang-masuk-single', [
                            'record' => $record,
                            'keterangan' => $data['ket_cetak'] ?? '',
                            'deskripsi' => $data['desk_cetak'] ?? '',
                        ]))
                            ->setPaper('a4', 'landscape');

                        return response()->streamDownload(
                            fn() => print($pdf->output()),
                            "barang-masuk-{$record->no_transaksi}.pdf"
                        );
                    }),

            ])



            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),

                Tables\Actions\BulkAction::make('print')
                    ->label('Cetak Terpilih')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->action(function (Collection $records) {
                        $pdf = Pdf::loadHTML(view('pdf.barang-masuk-bulk', [
                            'records' => $records,
                            'tanggal' => now()->format('d F Y'),
                        ]));
                        return response()->streamDownload(
                            fn() => print($pdf->output()),
                            'laporan-barang-masuk.pdf'
                        );
                    }),
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
