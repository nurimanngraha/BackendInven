<?php

namespace App\Filament\Widgets;

use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Collection;

class BarangChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Barang Masuk & Keluar';

    protected function getData(): array
    {
        // Ambil data barang masuk
        $barangMasuk = BarangMasuk::selectRaw('DATE(created_at) as tanggal, COUNT(*) as total')
            ->groupByRaw('DATE(created_at)')
            ->orderByRaw('DATE(created_at)')
            ->pluck('total', 'tanggal');

        // Ambil data barang keluar
        $barangKeluar = BarangKeluar::selectRaw('DATE(created_at) as tanggal, COUNT(*) as total')
            ->groupByRaw('DATE(created_at)')
            ->orderByRaw('DATE(created_at)')
            ->pluck('total', 'tanggal');

        // Gabungkan semua tanggal unik (supaya label chart sinkron)
        $labels = collect($barangMasuk->keys())
            ->merge($barangKeluar->keys())
            ->unique()
            ->sort()
            ->values();

        return [
            'datasets' => [
                [
                    'label' => 'Barang Masuk',
                    'data' => $labels->map(fn ($tanggal) => $barangMasuk[$tanggal] ?? 0),
                    'borderColor' => '#36A2EB',
                    'backgroundColor' => 'rgba(54,162,235,0.2)',
                    'tension' => 0.4, // garis melengkung
                ],
                [
                    'label' => 'Barang Keluar',
                    'data' => $labels->map(fn ($tanggal) => $barangKeluar[$tanggal] ?? 0),
                    'borderColor' => '#FF6384',
                    'backgroundColor' => 'rgba(255,99,132,0.2)',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line'; // bisa juga 'bar'
    }
}
