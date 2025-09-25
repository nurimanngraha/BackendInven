<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Barang;
use App\Models\Aset;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;

class StatsOverview extends BaseWidget
{
    protected function getColumns(): int
    {
        return 4; // tampil dalam 4 kolom
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total Barang', Barang::count())
                ->icon('heroicon-o-archive-box')
                ->color('primary')
                ->description('Jumlah data barang')
                ->descriptionIcon('heroicon-o-check-circle'),

            Stat::make('Total Aset', Aset::count())
                ->icon('heroicon-o-building-office')
                ->color('success')
                ->description('Jumlah data aset')
                ->descriptionIcon('heroicon-o-cube'),

            Stat::make('Barang Masuk', BarangMasuk::count())
                ->icon('heroicon-o-arrow-down-tray')
                ->color('info')
                ->description('Jumlah barang masuk')
                ->descriptionIcon('heroicon-o-arrow-trending-up'),

            Stat::make('Barang Keluar', BarangKeluar::count())
                ->icon('heroicon-o-arrow-up-tray')
                ->color('danger')
                ->description('Jumlah barang keluar')
                ->descriptionIcon('heroicon-o-arrow-trending-down'),
        ];
    }
}
