<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamanAsetResource\Pages;
use App\Models\PeminjamanAset;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PeminjamanAsetResource extends Resource
{
    protected static ?string $model = PeminjamanAset::class;

    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationLabel = 'Peminjaman Aset';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('aset_id')
                    ->relationship('aset', 'nama_aset')
                    ->required()
                    ->label('Aset'),

                Forms\Components\TextInput::make('peminjam')
                    ->required()
                    ->label('Nama Peminjam'),

                Forms\Components\DatePicker::make('tanggal_pinjam')
                    ->required(),

                Forms\Components\DatePicker::make('tanggal_kembali'),

                Forms\Components\Select::make('status')
                    ->options([
                        'Dipinjam' => 'Dipinjam',
                        'Dikembalikan' => 'Dikembalikan',
                    ])
                    ->default('Dipinjam'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('aset.nama_aset')->label('Aset')->searchable(),
                Tables\Columns\TextColumn::make('peminjam')->searchable(),
                Tables\Columns\TextColumn::make('tanggal_pinjam')->date(),
                Tables\Columns\TextColumn::make('tanggal_kembali')->date(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'Dipinjam',
                        'success' => 'Dikembalikan',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Dipinjam' => 'Dipinjam',
                        'Dikembalikan' => 'Dikembalikan',
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPeminjamanAsets::route('/'),
            'create' => Pages\CreatePeminjamanAset::route('/create'),
            'edit' => Pages\EditPeminjamanAset::route('/{record}/edit'),
        ];
    }
}
