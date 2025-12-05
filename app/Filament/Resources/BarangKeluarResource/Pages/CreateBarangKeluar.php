<?php

namespace App\Filament\Resources\BarangKeluarResource\Pages;

use App\Filament\Resources\BarangKeluarResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateBarangKeluar extends CreateRecord
{
    protected static string $resource = BarangKeluarResource::class;

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
            ->body('Data Barang Keluar berhasil disimpan.')
            ->duration(3000);
    }
}

