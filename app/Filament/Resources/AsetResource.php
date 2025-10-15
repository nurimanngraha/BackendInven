<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AsetResource\Pages;
use App\Models\Aset;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AsetResource extends Resource
{
    protected static ?string $model = Aset::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationGroup = 'Manajemen Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_aset')
                    ->label('Nama Aset')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('merk_kode')
                    ->label('Merk/Kode')
                    ->maxLength(150),

                Forms\Components\Select::make('kategori')
                    ->label('Kategori')
                    ->options([
                        'Elektronik' => 'Elektronik',
                        'Furniture'  => 'Furniture',
                        'Lainnya'    => 'Lainnya',
                    ])
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'Aktif'    => 'Aktif',
                        'Rusak'    => 'Rusak',
                        'Dipinjam' => 'Dipinjam',
                        'Hilang'   => 'Hilang',
                    ])
                    ->required(),

                Forms\Components\DatePicker::make('log_pembaruan_barcode')
                    ->label('Log Pembaruan Barcode'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('nama_aset')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('merk_kode'),
                Tables\Columns\TextColumn::make('kategori'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('log_pembaruan_barcode')->date(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                
                // 🟧 Tombol BARCODE yang diperbaiki
                Tables\Actions\Action::make('barcode')
                    ->label('QR Code')
                    ->icon('heroicon-o-qr-code')
                    ->button()
                    ->color('warning')
                    // OPSI 1: Jika ingin menggunakan URL langsung ke test-qr
                    ->url(fn (Aset $record): string => 'http://127.0.0.1:8000/test-qr?aset_id=' . $record->id . '&nama=' . urlencode($record->nama_aset))
                    ->openUrlInNewTab(),
                
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
            'index'  => Pages\ListAset::route('/'),
            'create' => Pages\CreateAset::route('/create'),
            'edit'   => Pages\EditAset::route('/{record}/edit'),
        ];
    }

    // 🔹 Tambahan biar singular di sidebar
    public static function getPluralLabel(): string
    {
        return 'Aset';
    }

    public static function getLabel(): string
    {
        return 'Aset';
    }
}