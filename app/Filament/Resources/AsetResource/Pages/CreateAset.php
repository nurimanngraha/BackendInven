<?php

namespace App\Filament\Resources\AsetResource\Pages;

use App\Filament\Resources\AsetResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateAset extends CreateRecord
{
    protected static string $resource = AsetResource::class;
    protected function getRedirectUrl(): string
    {
        // Setelah create, balik ke halaman list/index
        return static::getResource()::getUrl('index');
        }
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Berhasil')
            ->body('Data Aset berhasil disimpan.')
            ->duration(3000);
    }
}
