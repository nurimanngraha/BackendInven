<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangResource\Pages;
use App\Models\Barang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Manajemen Data';
    protected static ?string $navigationLabel = 'Data Barang';
    protected static ?string $pluralLabel = 'Data Barang';

    // Form create/edit
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode_barang')
                    ->label('ID Barang')
                    ->disabled() // tampil tapi tidak bisa diubah
                    ->default(function () {
                        $lastBarang = Barang::latest('id')->first();
                        $lastNumber = $lastBarang ? intval(substr($lastBarang->kode_barang, 1)) : 0;
                        return 'B' . str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
                    }),

                Forms\Components\TextInput::make('nama_barang')
                    ->label('Nama Barang')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('jenis_barang')
                    ->label('Jenis Barang')
                    ->options([
                        'Elektronik' => 'Elektronik',
                        'Furniture' => 'Furniture',
                        'Perlengkapan Kantor' => 'Perlengkapan Kantor',
                        'Aksesoris' => 'Aksesoris',
                        'Alat' => 'Alat',
                        'Bahan' => 'Bahan',
                        'Lainnya' => 'Lainnya',
                    ])
                    ->required(),

                Forms\Components\Select::make('satuan')
                    ->label('Satuan')
                    ->options([
                        'Unit' => 'Unit',
                        'Pcs' => 'Pcs',
                        'Box' => 'Box',
                        'Kg' => 'Kg',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('stok')
                    ->label('Stok')
                    ->numeric()
                    ->required(),
            ]);
    }

    // Table index
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('No')->sortable(),
                Tables\Columns\TextColumn::make('kode_barang')->label('ID Barang')->sortable(),
                Tables\Columns\TextColumn::make('nama_barang')->label('Nama Barang')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('jenis_barang')->label('Jenis Barang'),
                Tables\Columns\TextColumn::make('stok')->label('Stok'),
                Tables\Columns\TextColumn::make('satuan')->label('Satuan'),
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal Input')->dateTime('d/m/Y H:i'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    // Relations
    public static function getRelations(): array
    {
        return [];
    }

    // Pages
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBarang::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'edit' => Pages\EditBarang::route('/{record}/edit'),
        ];
    }

    // Auto-generate kode_barang sebelum create
    public static function mutateFormDataBeforeCreate(array $data): array
    {
        $lastBarang = Barang::latest('id')->first();
        $lastNumber = $lastBarang ? intval(substr($lastBarang->kode_barang, 1)) : 0;

        $data['kode_barang'] = 'B' . str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);

        return $data;
    }
}
