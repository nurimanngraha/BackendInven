<?php

namespace App\Filament\Resources\BarangKeluarResource\Pages;

use App\Filament\Resources\BarangKeluarResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditBarangKeluar extends EditRecord
{
    protected static string $resource = BarangKeluarResource::class;

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
            ->body('Data Barang Keluar berhasil diubah.')
            ->duration(3000); // auto close 3 detik
    }
}
