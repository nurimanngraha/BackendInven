<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangKeluarResource\Pages;
use App\Models\BarangKeluar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangKeluarResource extends Resource
{
    protected static ?string $model = BarangKeluar::class;
    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-tray';
    protected static ?string $navigationGroup = 'Transaksi';

    public static function getLabel(): string
    {
        return 'Barang Keluar';
    }

    public static function getPluralLabel(): string
    {
        return 'Barang Keluar';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Transaksi')
                    ->schema([
                        Forms\Components\TextInput::make('no_transaksi')
                            ->label('No Transaksi')
                            ->default(fn () => 'T-BK-' . now()->format('ymd') . sprintf('%04d', (BarangKeluar::whereDate('created_at', today())->count() + 1)))
                            ->disabled()
                            ->dehydrated(true)
                            ->columnSpanFull(),

                        Forms\Components\DatePicker::make('tanggal_keluar')
                            ->label('Tanggal Keluar')
                            ->default(now())
                            ->required()
                            ->columnSpanFull(),
                    ]),
                
                Forms\Components\Section::make('Data Barang')
                    ->schema([
                        Forms\Components\Select::make('barang_id')
                            ->label('Nama Barang')
                            ->relationship('barang', 'nama_barang')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpanFull()
                            ->placeholder('Masukkan nama barang'),

                        Forms\Components\TextInput::make('jumlah')
                            ->label('Total Keluar')
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->columnSpanFull()
                            ->placeholder('Masukkan jumlah barang keluar'),
                    ]),
                
                Forms\Components\Section::make('Informasi Penerima')
                    ->schema([
                        Forms\Components\TextInput::make('penerima')
                            ->label('Nama Penerima')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->placeholder('Masukkan nama penerima'),

                        Forms\Components\TextInput::make('bagian')
                            ->label('Bagian')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->placeholder('Masukkan bagian penerima'),
                    ]),
                
                Forms\Components\Section::make('Petugas')
                    ->schema([
                        Forms\Components\TextInput::make('petugas')
                            ->label('Petugas')
                            ->required()
                            ->maxLength(255)
                            ->default(auth()->user()->name ?? 'Administrator')
                            ->columnSpanFull()
                            ->placeholder('Masukkan nama petugas'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                Tables\Actions\Action::make('totalKeluar')
                    ->label(fn () => 'Total Keluar: ' . number_format(BarangKeluar::sum('jumlah'), 0, ',', '.') . ' Unit')
                    ->color('gray')
                    ->disabled()
                    ->extraAttributes(['class' => 'bg-gray-100 px-4 py-2 rounded-lg']),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('no_transaksi')
                    ->label('No Transaksi')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('tanggal_keluar')
                    ->label('Tgl Keluar')
                    ->date('Y-m-d')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('barang.nama_barang')
                    ->label('Nama Barang')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->formatStateUsing(fn ($state, $record) => number_format($state, 0, ',', '.') . ' ' . ($record->barang->satuan ?? 'Unit'))
                    ->sortable()
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                            ->label('Total Keluar')
                            ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.') . ' Unit')
                    ]),
                    
                Tables\Columns\TextColumn::make('penerima')
                    ->label('Penerima')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('bagian')
                    ->label('Bagian')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('petugas')
                    ->label('Petugas')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('tanggal_keluar')
                    ->form([
                        Forms\Components\DatePicker::make('dari_tanggal')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('sampai_tanggal')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['dari_tanggal'], fn ($q) => $q->whereDate('tanggal_keluar', '>=', $data['dari_tanggal']))
                            ->when($data['sampai_tanggal'], fn ($q) => $q->whereDate('tanggal_keluar', '<=', $data['sampai_tanggal']));
                    }),
            ])
            ->actions([
            // Tampilkan tombol satu per satu (bukan ActionGroup)
            Tables\Actions\ViewAction::make(),
                // ->label('View')
                // ->icon('heroicon-o-eye')
                // ->button()
                // ->color('gray'),

            Tables\Actions\EditAction::make(),
                // ->label('Edit')
                // ->icon('heroicon-o-pencil-square')
                // ->button()
                // ->color('warning'),

            Tables\Actions\DeleteAction::make(),
                // ->label('Delete')
                // ->icon('heroicon-o-trash')
                // ->button()
                // ->color('danger'),

            Tables\Actions\Action::make('print')
                // ->label('Cetak')
                // ->icon('heroicon-o-printer')
                // ->button()
                // ->color('success')
                ->action(function (BarangKeluar $record) {
                    // Normalisasi tanggal_keluar (string / Carbon)
                    $tanggal_keluar = $record->tanggal_keluar;
                    if (is_string($tanggal_keluar)) {
                        $tanggal_keluar = \Carbon\Carbon::parse($tanggal_keluar)->format('Y-m-d');
                    } else {
                        $tanggal_keluar = $record->tanggal_keluar->format('Y-m-d');
                    }

                    $data = [
                        'no_transaksi'   => $record->no_transaksi,
                        'tanggal_keluar' => $tanggal_keluar,
                        'nama_barang'    => $record->barang->nama_barang,
                        'jumlah'         => number_format($record->jumlah, 0, ',', '.') . ' ' . ($record->barang->satuan ?? 'Unit'),
                        'penerima'       => $record->penerima,
                        'bagian'         => $record->bagian,
                        'petugas'        => $record->petugas,
                    ];

                    $pdf = Pdf::loadView('pdf.barang-keluar-single', $data);

                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        "barang-keluar-{$record->no_transaksi}.pdf"
                    );
                }),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),

                Tables\Actions\BulkAction::make('print')
                    ->label('Cetak Selected')
                    ->icon('heroicon-o-printer')
                    ->action(function (Collection $records) {
                        $totalKeluar = $records->sum('jumlah');

                        $data = [
                            'records' => $records->map(function ($record) {
                                // Normalisasi tanggal_keluar (string / Carbon)
                                $tanggal_keluar = $record->tanggal_keluar;
                                if (is_string($tanggal_keluar)) {
                                    $tanggal_keluar = \Carbon\Carbon::parse($tanggal_keluar)->format('Y-m-d');
                                } else {
                                    $tanggal_keluar = $record->tanggal_keluar->format('Y-m-d');
                                }

                                return [
                                    'no_transaksi'   => $record->no_transaksi,
                                    'tanggal_keluar' => $tanggal_keluar,
                                    'nama_barang'    => $record->barang->nama_barang,
                                    'jumlah'         => number_format($record->jumlah, 0, ',', '.') . ' ' . ($record->barang->satuan ?? 'Unit'),
                                    'penerima'       => $record->penerima,
                                    'bagian'         => $record->bagian,
                                    'petugas'        => $record->petugas,
                                ];
                            }),
                            'total_keluar' => number_format($totalKeluar, 0, ',', '.') . ' Unit',
                            'tanggal_cetak'=> now()->format('Y-m-d H:i'),
                        ];

                        $pdf = Pdf::loadView('pdf.barang-keluar-bulk', $data);

                        return response()->streamDownload(
                            fn () => print($pdf->output()),
                            'laporan-barang-keluar.pdf'
                        );
                    }),
            ]),
        ])
        ->emptyStateActions([
            Tables\Actions\CreateAction::make(),
        ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBarangKeluar::route('/'),
            'create' => Pages\CreateBarangKeluar::route('/create'),
            'edit' => Pages\EditBarangKeluar::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}