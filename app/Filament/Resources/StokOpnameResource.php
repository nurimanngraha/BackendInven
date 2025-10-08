<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StokOpnameResource\Pages;
use App\Models\StokOpname;
use App\Models\Aset;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\TextColumn;

class StokOpnameResource extends Resource
{
    protected static ?string $model = StokOpname::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationLabel = 'Stok Opname';
    protected static ?string $pluralLabel = 'Stok Opnames';
    protected static ?string $modelLabel = 'Stok Opname';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Grid::make(2)->schema([
                    TextInput::make('nama_barang')
                        ->label('Nama Barang')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('barcode')
                        ->label('Barcode')
                        ->unique(ignoreRecord: true)
                        ->required(),

                    TextInput::make('stok_sistem')
                        ->label('Stok Sistem')
                        ->numeric()
                        ->minValue(0)
                        ->default(0)
                        ->required(),

                    TextInput::make('stok_fisik')
                        ->label('Stok Fisik')
                        ->numeric()
                        ->minValue(0)
                        ->default(0)
                        ->required()
                        ->afterStateUpdated(function ($state, callable $set, $get) {
                            $set('selisih', $state - $get('stok_sistem'));
                        }),

                    TextInput::make('selisih')
                        ->label('Selisih')
                        ->numeric()
                        ->disabled()
                        ->default(0),

                    Select::make('status')
                        ->options([
                            'ok' => 'OK',
                            'rusak' => 'Rusak',
                        ])
                        ->default('ok')
                        ->required(),
                ]),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_barang')->label('Nama Barang')->sortable()->searchable(),
                TextColumn::make('barcode')->label('Barcode')->sortable()->searchable(),
                TextColumn::make('stok_sistem')->label('Stok Sistem')->sortable(),
                TextColumn::make('stok_fisik')->label('Stok Fisik')->sortable(),
                TextColumn::make('selisih')->label('Selisih')->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'warning' => ['Rusak'],
                        'success' => ['Ok'],
                    ])
                    ->sortable(),
                TextColumn::make('created_at')->label('Dibuat')->dateTime()->sortable(),
                TextColumn::make('updated_at')->label('Diubah')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options([
                    'ok' => 'OK',
                    'rusak' => 'Rusak',
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                
            Tables\Actions\Action::make('barcode')
                ->label('Barcode')
                ->icon('heroicon-o-qr-code')
                ->button()
                ->color('warning')
                ->url(fn (Aset $record) => rtrim(env('FRONTEND_URL', 'http://localhost:5173'), '/').'/labels/'.$record->id)
                ->openUrlInNewTab(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStokOpnames::route('/'),
            'create' => Pages\CreateStokOpname::route('/create'),
            'edit' => Pages\EditStokOpname::route('/{record}/edit'),
        ];
    }
}
