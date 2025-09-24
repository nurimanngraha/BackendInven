<?php

namespace App\Filament\Resources\BarangMasukResource\Pages;

use App\Filament\Resources\BarangMasukResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;

class ListBarangMasuk extends ListRecords
{
    protected static string $resource = BarangMasukResource::class;

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
