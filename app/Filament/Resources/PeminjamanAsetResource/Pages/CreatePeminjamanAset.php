<?php

namespace App\Filament\Resources\PeminjamanAsetResource\Pages;

use App\Filament\Resources\PeminjamanAsetResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreatePeminjamanAset extends CreateRecord
{
    protected static string $resource = PeminjamanAsetResource::class;
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
            ->body('Data Peminjaman berhasil disimpan.')
            ->duration(3000);
    }
}
