<?php

namespace App\Filament\Resources;

use App\Models\PeminjamanAset;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\PeminjamanAsetResource\Pages;

class PeminjamanAsetResource extends Resource
{
    protected static ?string $model = PeminjamanAset::class;

    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationLabel = 'Peminjaman Aset';

    // 🔹 Atur label agar tidak typo jadi "Asets"
    public static function getModelLabel(): string
    {
        return 'Peminjaman Aset';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Peminjaman Aset';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('aset_id')
                ->relationship('aset', 'nama_aset')
                ->required()
                ->label('Nama Barang'),

            Forms\Components\TextInput::make('peminjam')
                ->required()
                ->label('Peminjam'),

            Forms\Components\TextInput::make('bagian')
                ->label('Bagian / Divisi'),

            Forms\Components\DatePicker::make('tanggal_pinjam')
                ->required()
                ->label('Tanggal Pinjam'),

            Forms\Components\DatePicker::make('tanggal_kembali')
                ->label('Tanggal Kembali'),

            Forms\Components\TextInput::make('jumlah')
                ->numeric()
                ->required()
                ->label('Jumlah'),

            Forms\Components\TextInput::make('sisa_stok')
                ->numeric()
                ->label('Sisa Stok'),

            Forms\Components\Hidden::make('status')
                ->default('Dipinjam'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('aset.nama_aset')
                    ->label('Aset')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('peminjam')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('bagian')
                    ->label('Bagian')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_pinjam')
                    ->date()
                    ->label('Tanggal Pinjam')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_kembali')
                    ->date()
                    ->label('Tanggal Kembali')
                    ->placeholder('-')
                    ->sortable(),

                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah'),

                Tables\Columns\TextColumn::make('sisa_stok')
                    ->label('Sisa Stok'),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
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
                    ->action(fn ($record) => $record->update([
                        'status' => 'Dikembalikan',
                        'tanggal_kembali' => now(),
                    ])),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('kembalikan')
                    ->label('Kembalikan')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Collection $records) {
                        $records->each(function ($record) {
                            if ($record->status === 'Dipinjam') {
                                $record->update([
                                    'status' => 'Dikembalikan',
                                    'tanggal_kembali' => now(),
                                ]);
                            }
                        });
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPeminjamanAset::route('/'),
            'create' => Pages\CreatePeminjamanAset::route('/create'),
            'edit'   => Pages\EditPeminjamanAset::route('/{record}/edit'),
        ];
    }
}
