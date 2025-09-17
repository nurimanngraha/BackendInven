<?php

namespace App\Filament\Widgets;

use App\Models\Barang;
use App\Models\Aset;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Barang', Barang::count())
                ->description('Jumlah data barang')
                ->color('primary'),

            Stat::make('Total Aset', Aset::count())
                ->description('Jumlah data aset')
                ->color('success'),

            Stat::make('Barang Masuk', BarangMasuk::count())
                ->description('Jumlah barang masuk')
                ->color('info'),

            Stat::make('Barang Keluar', BarangKeluar::count())
                ->description('Jumlah barang keluar')
                ->color('danger'),
        ];
    }
}
