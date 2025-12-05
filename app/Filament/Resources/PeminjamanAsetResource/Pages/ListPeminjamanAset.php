<?php

namespace App\Filament\Resources\PeminjamanAsetResource\Pages;

use App\Filament\Resources\PeminjamanAsetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPeminjamanAset extends ListRecords
{
    protected static string $resource = PeminjamanAsetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Barang Masuk')
            ->icon('heroicon-o-plus'),

        ];
    }
}
