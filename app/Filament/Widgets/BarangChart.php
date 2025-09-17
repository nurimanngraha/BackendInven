<?php

namespace App\Filament\Widgets;

use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Filament\Widgets\ChartWidget;

class BarangChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Barang Masuk & Keluar';

    protected function getData(): array
    {
        // Barang Masuk
        $barangMasuk = BarangMasuk::selectRaw('DATE(created_at) as tanggal, COUNT(*) as total')
            ->groupByRaw('DATE(created_at)')
            ->orderByRaw('DATE(created_at)')
            ->pluck('total', 'tanggal');

        // Barang Keluar
        $barangKeluar = BarangKeluar::selectRaw('DATE(created_at) as tanggal, COUNT(*) as total')
            ->groupByRaw('DATE(created_at)')
            ->orderByRaw('DATE(created_at)')
            ->pluck('total', 'tanggal');

        return [
            'datasets' => [
                [
                    'label' => 'Barang Masuk',
                    'data' => $barangMasuk->values(),
                    'borderColor' => '#36A2EB',
                    'backgroundColor' => 'rgba(54,162,235,0.2)',
                ],
                [
                    'label' => 'Barang Keluar',
                    'data' => $barangKeluar->values(),
                    'borderColor' => '#FF6384',
                    'backgroundColor' => 'rgba(255,99,132,0.2)',
                ],
            ],
            'labels' => $barangMasuk->keys(), // ambil tanggal dari Barang Masuk
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Bisa diganti 'bar' kalau mau
    }
}
