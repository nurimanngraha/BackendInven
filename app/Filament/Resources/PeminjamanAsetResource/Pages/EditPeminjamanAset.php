<?php

namespace App\Filament\Resources\PeminjamanAsetResource\Pages;

use App\Filament\Resources\PeminjamanAsetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditPeminjamanAset extends EditRecord
{
    protected static string $resource = PeminjamanAsetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Berhasil')
            ->body('Data Peminjam berhasil diubah.')
            ->duration(3000); // auto close 3 detik
    }
}
