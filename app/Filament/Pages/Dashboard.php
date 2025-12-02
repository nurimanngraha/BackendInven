<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\BarangPieChart;
use App\Filament\Widgets\BarangComparisonTable;
use App\Filament\Widgets\BarangChart;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
            BarangComparisonTable::class,
            BarangChart::class,
            BarangPieChart::class,
        ];
    }

    public function getColumns(): int|array
    {
        return [
            'sm' => 1,
            'md' => 2, // 👉 2 kolom sejajar di layar besar
            'xl' => 2,
        ];
    }
}


