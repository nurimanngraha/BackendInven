<?php

namespace App\Filament\Resources\AsetResource\Pages;

use App\Filament\Resources\AsetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAset extends ListRecords
{
    protected static string $resource = AsetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Aset')
                ->icon('heroicon-o-plus'),
        ];
    }

    public function getTitle(): string
    {
        return 'Daftar Aset';
    }
}
