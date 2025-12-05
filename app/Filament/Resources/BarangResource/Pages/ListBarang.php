<?php

namespace App\Filament\Resources\BarangResource\Pages;

use App\Filament\Resources\BarangResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class ListBarang extends ListRecords
{
    protected static string $resource = BarangResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make()
                ->label('Barang')
                ->icon('heroicon-o-plus'),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            EditAction::make()->label('Edit'),
            DeleteAction::make()->label('Hapus'),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [
            BulkActionGroup::make([
                DeleteBulkAction::make()->label('Hapus Terpilih'),
            ]),
        ];
    }
}
