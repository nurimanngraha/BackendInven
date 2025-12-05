<?php

namespace App\Filament\Resources\BarangResource\Pages;

use App\Filament\Resources\BarangResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditBarang extends EditRecord
{
    protected static string $resource = BarangResource::class;
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
            ->body('Data Barang berhasil diubah.')
            ->duration(3000); // auto close 3 detik
    }
}
