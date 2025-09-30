<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PeminjamanAset;
use Filament\Resources\Resource;
use App\Filament\Resources\PeminjamanAsetResource\Pages;
use Illuminate\Database\Eloquent\Collection;

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

                Forms\Components\TextInput::make('bagian')
                    ->label('Bagian / Departemen'),

                Forms\Components\DatePicker::make('tanggal_pinjam')
                    ->required()
                    ->label('Tanggal Pinjam'),

                Forms\Components\DatePicker::make('tanggal_kembali')
                    ->label('Tanggal Kembali')
                    ->nullable(),

                Forms\Components\TextInput::make('jumlah')
                    ->numeric()
                    ->default(1)
                    ->required()
                    ->label('Jumlah'),

                Forms\Components\Select::make('status')
                    ->options([
                        'Dipinjam' => 'Dipinjam',
                        'Dikembalikan' => 'Dikembalikan',
                    ])
                    ->default('Dipinjam')
                    ->label('Status'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('aset.nama_aset')->label('Aset')->searchable(),
                Tables\Columns\TextColumn::make('peminjam')->searchable(),
                Tables\Columns\TextColumn::make('bagian')->label('Bagian'),
                Tables\Columns\TextColumn::make('jumlah'),
                Tables\Columns\TextColumn::make('tanggal_pinjam')->date(),
                Tables\Columns\TextColumn::make('tanggal_kembali')->date()->label('Tanggal Kembali')->placeholder('-'),
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
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('kembalikan')
                    ->label('Kembalikan')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === 'Dipinjam')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'Dikembalikan',
                            'tanggal_kembali' => now(),
                        ]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('kembalikan')
                    ->label('Kembalikan')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                            if ($record->status === 'Dipinjam') {
                                $record->update([
                                    'status' => 'Dikembalikan',
                                    'tanggal_kembali' => now(),
                                ]);
                            }
                        }
                    }),
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
