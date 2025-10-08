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
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Transaksi')
                    ->schema([
                        Forms\Components\TextInput::make('no_transaksi')
                            ->label('No Transaksi')
                            ->default(fn () => 'T-BK-' . now()->format('Ymd') . rand(1000, 9999))
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

                        Forms\Components\Select::make('kategori')
                            ->label('Kategori')
                            ->options([
                                'Elektronik' => 'Elektronik',
                                'Alat Tulis' => 'Alat Tulis',
                            ])
                            ->searchable()
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Informasi User')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('User')
                            ->relationship('user', 'name')
                            ->default(auth()->id())
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
                    ->label('Barang')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.') . ' unit'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal Masuk')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->options([
                        'Elektronik' => 'Elektronik',
                        'Alat Tulis' => 'Alat Tulis',
                    ])
                    ->label('Filter Kategori'),

                Tables\Filters\Filter::make('tanggal')
                    ->form([
                        Forms\Components\DatePicker::make('dari_tanggal')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('sampai_tanggal')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['dari_tanggal'], fn ($q) => $q->whereDate('tanggal', '>=', $data['dari_tanggal']))
                            ->when($data['sampai_tanggal'], fn ($q) => $q->whereDate('tanggal', '<=', $data['sampai_tanggal']));
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    
                    // Print Single Record
                    Tables\Actions\Action::make('print')
                        ->label('Cetak')
                        ->icon('heroicon-o-printer')
                        ->color('success')
                        ->action(function (BarangMasuk $record) {
                            $pdf = Pdf::loadHTML(
                                view('pdf.barang-masuk-single', ['record' => $record])
                            );
                            
                            return response()->streamDownload(
                                fn () => print($pdf->output()),
                                "barang-masuk-{$record->no_transaksi}.pdf"
                            );
                        }),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    
                    // Print Multiple Records
                    Tables\Actions\BulkAction::make('print')
                        ->label('Cetak Selected')
                        ->icon('heroicon-o-printer')
                        ->action(function (Collection $records) {
                            $pdf = Pdf::loadHTML(
                                view('pdf.barang-masuk-bulk', [
                                    'records' => $records,
                                    'tanggal' => now()->format('d F Y')
                                ])
                            );
                            
                            return response()->streamDownload(
                                fn () => print($pdf->output()),
                                'laporan-barang-masuk.pdf'
                            );
                        }),
                ]),
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