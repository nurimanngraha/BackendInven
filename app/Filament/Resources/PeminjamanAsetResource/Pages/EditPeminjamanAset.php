<?php

namespace App\Filament\Resources\PeminjamanAsetResource\Pages;

use App\Filament\Resources\PeminjamanAsetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPeminjamanAset extends EditRecord
{
    protected static string $resource = PeminjamanAsetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
