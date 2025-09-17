<?php

namespace App\Filament\Pages;

use App\Models\Barang;
use App\Models\Aset;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget;
use App\Filament\Widgets\BarangPieChart;
use App\Filament\Widgets\BarangComparisonTable;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
            BarangPieChart::class,
            BarangComparisonTable::class,
        ];
    }
}

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Barang', Barang::count()),
            Stat::make('Total Aset', Aset::count()),
            Stat::make('Barang Masuk', BarangMasuk::count()),
            Stat::make('Barang Keluar', BarangKeluar::count()),
        ];
    }
}
