<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class BarangComparisonTable extends BaseWidget
{
    protected static ?string $heading = 'Perbandingan Barang Masuk & Keluar per Bulan';
    protected int|string|array $columnSpan = 'full';

    /**
     * Tetap return Builder tapi dengan record yang aman
     */
    protected function getTableQuery(): Builder
    {
        return BarangMasuk::query()
            ->selectRaw("DATE_FORMAT(created_at, '%M %Y') as bulan, MIN(id) as min_id")
            ->groupByRaw("DATE_FORMAT(created_at, '%M %Y')")
            ->orderByRaw("MIN(created_at)");
    }

    /**
     * Override method untuk handle record tanpa primary key
     */
    public function getTableRecordKey($record): string
    {
        // Gunakan kombinasi bulan + min_id sebagai key yang unique
        if (isset($record->bulan) && !empty($record->bulan)) {
            $key = 'month_' . $record->bulan;
            
            // Tambahkan min_id untuk memastikan uniqueness
            if (isset($record->min_id) && !empty($record->min_id)) {
                $key .= '_' . $record->min_id;
            }
            
            return $key;
        }
        
        // Fallback emergency
        return uniqid('comparison_', true);
    }

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