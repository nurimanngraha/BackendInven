<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangKeluarResource\Pages;
use App\Models\BarangKeluar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BarangKeluarResource extends Resource
{
    protected static ?string $model = BarangKeluar::class;
    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-tray';
    protected static ?string $navigationGroup = 'Transaksi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\TextInput::make('no_transaksi')
                ->label('No. Transaksi')
                ->default(fn () => 'Auto Generate')
                ->disabled()
                ->dehydrated(true),

                Forms\Components\Select::make('barang_id')
                    ->label('Barang')
                    ->relationship('barang', 'nama_barang')
                    ->required()
                    ->searchable(),

                Forms\Components\DatePicker::make('tanggal_keluar')
                    ->label('Tanggal Keluar')
                    ->default(now()) // ✅ otomatis isi hari ini
                    ->required(),

                Forms\Components\TextInput::make('jumlah')
                    ->label('Jumlah')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('penerima')
                    ->label('Penerima')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('bagian')
                    ->label('Bagian')
                    ->nullable()
                    ->maxLength(255),

                Forms\Components\TextInput::make('petugas')
                    ->label('Petugas')
                    ->nullable()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_transaksi')->label('No. Transaksi')->sortable(),
                Tables\Columns\TextColumn::make('barang.nama_barang')->label('Barang'),
                Tables\Columns\TextColumn::make('tanggal_keluar')->date(),
                Tables\Columns\TextColumn::make('jumlah'),
                Tables\Columns\TextColumn::make('penerima'),
                Tables\Columns\TextColumn::make('bagian')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('petugas')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->since()->sortable(),
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBarangKeluars::route('/'),
            'create' => Pages\CreateBarangKeluar::route('/create'),
            'edit' => Pages\EditBarangKeluar::route('/{record}/edit'),
        ];
    }
}
