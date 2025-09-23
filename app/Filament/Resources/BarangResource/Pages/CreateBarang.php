<?php

namespace App\Filament\Resources\BarangResource\Pages;

use App\Filament\Resources\BarangResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Barang;

class CreateBarang extends CreateRecord
{
    protected static string $resource = BarangResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $lastBarang = Barang::latest('id')->first();
        $lastNumber = $lastBarang ? intval(substr($lastBarang->kode_barang, 1)) : 0;

        // Auto generate kode barang -> B000001, B000002, dst
        $data['kode_barang'] = 'B' . str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);

        return $data;
    }
}
