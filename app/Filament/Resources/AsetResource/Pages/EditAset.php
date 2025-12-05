<?php

namespace App\Filament\Resources\AsetResource\Pages;

use App\Filament\Resources\AsetResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditAset extends EditRecord
{
    protected static string $resource = AsetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        // Setelah create, balik ke halaman list/index
        return static::getResource()::getUrl('index');
        }
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Berhasil')
            ->body('Data Aset berhasil diubah.')
            ->duration(3000); // auto close 3 detik
    }
}
