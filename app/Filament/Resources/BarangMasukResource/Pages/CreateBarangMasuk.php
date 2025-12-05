<?php

namespace App\Filament\Resources\BarangMasukResource\Pages;

use App\Filament\Resources\BarangMasukResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateBarangMasuk extends CreateRecord
{
    protected static string $resource = BarangMasukResource::class;

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
            ->body('Data Barang Masuk berhasil disimpan.')
            ->duration(3000);
    }
}
