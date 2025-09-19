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
                Forms\Components\TextInput::make('no_transaksi')
                    ->label('No Transaksi')
                    ->default(fn() => 'T-BK-' . now()->format('Ymd') . rand(1000, 9999))
                    ->disabled()
                    ->columnSpanFull(),

                Forms\Components\DatePicker::make('tanggal')
                    ->label('Tanggal Masuk')
                    ->default(now())
                    ->required()
                    ->columnSpanFull(),
                    
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
                    ->columnSpanFull(),

                // Perbaikan: Menambahkan email placeholder saat membuat user baru
                Forms\Components\TextInput::make('user_baru')
                    ->label('User')
                    ->required()
                    ->autocomplete(false)
                    ->afterStateUpdated(function ($state, $set) {
                        $user = \App\Models\User::firstOrCreate(
                            ['name' => $state],
                            ['email' => strtolower(str_replace(' ', '', $state)) . '@example.com', 'password' => 'password']
                        );
                        $set('user_id', $user->id);
                    })
                    ->columnSpanFull(),
                
                // Kolom user_id yang tersembunyi untuk menyimpan ID user
                Forms\Components\Hidden::make('user_id'),

                Forms\Components\TextInput::make('kategori_baru')
                    ->label('Kategori')
                    ->required()
                    ->autocomplete(false)
                    ->columnSpanFull(),
                
                Forms\Components\Hidden::make('kategori_id'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_transaksi')->label('No Transaksi'),
                Tables\Columns\TextColumn::make('barang.nama_barang')->label('Barang')->searchable(),
                Tables\Columns\TextColumn::make('kategori.nama_kategori')->label('Kategori')->searchable(),
                Tables\Columns\TextColumn::make('jumlah')->label('Jumlah'),
                Tables\Columns\TextColumn::make('user.name')->label('User'),
                Tables\Columns\TextColumn::make('tanggal')->date()->label('Tanggal Masuk'),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y H:i')->label('Dibuat'),
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