<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangMasukResource\Pages;
use App\Models\BarangMasuk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BarangMasukResource extends Resource
{
    protected static ?string $model = BarangMasuk::class;

    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-tray';
    protected static ?string $navigationLabel = 'Barang Masuk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // No Transaksi otomatis
                Forms\Components\TextInput::make('no_transaksi')
                    ->label('No Transaksi')
                    ->default(fn() => 'T-BK-' . now()->format('Ymd') . rand(1000, 9999))
                    ->disabled()
                    ->dehydrated(true)
                    ->columnSpanFull(),

                // Tanggal Masuk
                Forms\Components\DatePicker::make('tanggal')
                    ->label('Tanggal Masuk')
                    ->default(now())
                    ->required()
                    ->columnSpanFull(),
                
                // Barang (relasi)
                Forms\Components\Select::make('barang_id')
                    ->label('Nama Barang')
                    ->relationship('barang', 'nama_barang')
                    ->searchable()
                    ->required()
                    ->columnSpanFull(),

                // Jumlah
                Forms\Components\TextInput::make('jumlah')
                    ->label('Jumlah Masuk')
                    ->numeric()
                    ->required()
                    ->columnSpanFull(),

                // ✅ Kategori manual (dropdown statis, string biasa)
                Forms\Components\Select::make('kategori')
                    ->label('Kategori')
                    ->options([
                        'Elektronik' => 'Elektronik',
                        'Alat Tulis' => 'Alat Tulis',
                        'Makanan'    => 'Makanan',
                        'Minuman'    => 'Minuman',
                    ])
                    ->searchable()
                    ->required()
                    ->columnSpanFull(),

                // User (relasi)
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->default(auth()->id())
                    ->searchable()
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_transaksi')
                    ->label('No Transaksi')
                    ->searchable(),

                Tables\Columns\TextColumn::make('barang.nama_barang')
                    ->label('Barang')
                    ->searchable(),

                // ✅ kategori langsung dari kolom string
                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori')
                    ->searchable(),

                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tanggal')
                    ->date()
                    ->label('Tanggal Masuk'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->label('Dibuat'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBarangMasuks::route('/'),
            'create' => Pages\CreateBarangMasuk::route('/create'),
            'edit' => Pages\EditBarangMasuk::route('/{record}/edit'),
        ];
    }
}
