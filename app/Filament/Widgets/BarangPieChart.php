<?php

namespace App\Filament\Widgets;

use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Filament\Widgets\PieChartWidget;

class BarangPieChart extends PieChartWidget
{
    protected static ?string $heading = 'Perbandingan Barang Masuk & Keluar';

    protected function getData(): array
    {
        $totalMasuk = BarangMasuk::count();
        $totalKeluar = BarangKeluar::count();

        return [
            'datasets' => [
                [
                    'label' => 'Barang',
                    'data' => [$totalMasuk, $totalKeluar],
                    'backgroundColor' => ['#36A2EB', '#FF6384'],
                ],
            ],
            'labels' => ['Barang Masuk', 'Barang Keluar'],
        ];
    }
}
