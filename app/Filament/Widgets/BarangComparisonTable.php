<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Database\Eloquent\Builder;

class BarangComparisonTable extends BaseWidget
{
    protected static ?string $heading = 'Perbandingan Barang Masuk & Keluar per Bulan';

    protected int|string|array $columnSpan = 'full';

    /**
     * Gunakan Eloquent Builder dari model BarangMasuk.
     */
    protected function getTableQuery(): Builder
    {
        return BarangMasuk::query()
            ->selectRaw("DATE_FORMAT(created_at, '%M %Y') as bulan")
            ->groupByRaw("DATE_FORMAT(created_at, '%M %Y')")
            ->orderByRaw("MIN(created_at)");
    }

    /**
     * Definisikan kolom tabel.
     */
    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('bulan')
                ->label('Bulan'),

            Tables\Columns\TextColumn::make('total_masuk')
                ->label('Barang Masuk')
                ->getStateUsing(fn ($record) =>
                    BarangMasuk::whereRaw("DATE_FORMAT(created_at, '%M %Y') = ?", [$record->bulan])->count()
                ),

            Tables\Columns\TextColumn::make('total_keluar')
                ->label('Barang Keluar')
                ->getStateUsing(fn ($record) =>
                    BarangKeluar::whereRaw("DATE_FORMAT(created_at, '%M %Y') = ?", [$record->bulan])->count()
                ),
        ];
    }
}
