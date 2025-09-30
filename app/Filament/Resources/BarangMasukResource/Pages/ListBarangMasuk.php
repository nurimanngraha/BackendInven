<?php

namespace App\Filament\Resources\BarangMasukResource\Pages;

use App\Filament\Resources\BarangMasukResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Actions\CreateAction; // Import CreateAction

class ListBarangMasuk extends ListRecords
{
    protected static string $resource = BarangMasukResource::class;

    // Menambahkan tombol Tambah Barang Masuk ke header halaman
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    // Tombol di setiap baris tabel (Edit dan Delete)
    protected function getTableActions(): array
    {
        return [
            Tables\Actions\EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
