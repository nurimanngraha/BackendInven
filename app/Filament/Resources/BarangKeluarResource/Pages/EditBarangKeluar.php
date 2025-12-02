<?php

namespace App\Filament\Resources\BarangKeluarResource\Pages;

use App\Filament\Resources\BarangKeluarResource;
use Filament\Resources\Pages\EditRecord;

class EditBarangKeluar extends EditRecord
{
    protected static string $resource = BarangKeluarResource::class;

    protected function getRedirectUrl(): string
    {
        // Setelah create, balik ke halaman list/index
        return static::getResource()::getUrl('index');
        }
}
