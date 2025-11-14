<?php

namespace App\Filament\Resources\StokOpnameResource\Pages;

use App\Filament\Resources\StokOpnameResource;
use Filament\Resources\Pages\ListRecords;

class ListStokOpnames extends ListRecords
{
    protected static string $resource = StokOpnameResource::class;

    // Hapus heading bawaan
    public function getHeading(): string
    {
        return ''; // kosongkan teks
    }

    // Hapus seluruh header bawaan Filament
    public function getHeader(): ?\Illuminate\Contracts\View\View
    {
        return null;
    }

    // Gunakan view custom kamu sendiri
    protected static string $view = 'filament.resources.stok-opname.list';
}
