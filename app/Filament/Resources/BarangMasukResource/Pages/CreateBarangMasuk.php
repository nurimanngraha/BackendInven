<?php

namespace App\Filament\Resources\BarangMasukResource\Pages;

use App\Filament\Resources\BarangMasukResource;
use App\Models\Kategori;
use Filament\Resources\Pages\CreateRecord;

class CreateBarangMasuk extends CreateRecord
{
    protected static string $resource = BarangMasukResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Simpan kategori ke tabel kategoris (jika belum ada)
        $kategori = Kategori::firstOrCreate([
            'nama_kategori' => $data['kategori']
        ]);

        // kalau kamu ingin menyimpan foreign key kategori_id di barang_masuk:
        // $data['kategori_id'] = $kategori->id;

        // kalau cukup simpan nama kategori langsung di barang_masuk:
        $data['kategori'] = $kategori->nama_kategori;

        return $data;
    }
}
