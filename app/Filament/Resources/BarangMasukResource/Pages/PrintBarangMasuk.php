<?php

namespace App\Filament\Resources\BarangMasukResource\Pages;

use App\Filament\Resources\BarangMasukResource;
use App\Models\BarangMasuk;
use Filament\Resources\Pages\Page;
use PDF; // Penting: Tambahkan use untuk PDF

class PrintBarangMasuk extends Page
{
    protected static string $resource = BarangMasukResource::class;

    protected static string $view = 'filament.resources.barang-masuk-resource.pages.print-barang-masuk';

    public $data;

    public function mount()
    {
        // Ambil semua data Barang Masuk dengan relasi
        $this->data = BarangMasuk::with(['barang', 'kategori', 'user'])->get();
    }

    public function printToPdf()
    {
        $pdf = PDF::loadView('filament.resources.barang-masuk-resource.pages.print-barang-masuk', ['data' => $this->data]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'laporan-barang-masuk-' . now()->format('Y-m-d') . '.pdf');
    }
}