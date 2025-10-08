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
                            // 🟧 Tombol BARCODE (di tengah, antara Edit dan Delete)
            Tables\Actions\Action::make('barcode')
                ->label('Barcode')
                ->icon('heroicon-o-qr-code')   // ikon heroicons
                ->button()                     // render sebagai button (bukan link tipis)
                ->color('warning')             // bebas ganti: primary / info / success / etc
                // opsi A: buka halaman label (siap cetak) di tab baru
                ->url(fn (Aset $record) => route('assets.print', $record))
                ->openUrlInNewTab(),
                // kalau mau selalu tampil, biarkan. Kalau mau sembunyikan saat belum ada file:
                // ->visible(fn (Aset $record) => filled($record->qr_path))
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
