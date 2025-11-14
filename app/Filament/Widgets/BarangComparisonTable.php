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

    // ✅ Matikan default sort bawaan Filament
    protected bool $hasTableDefaultSort = false;

    // ✅ Tambahkan ini untuk memastikan Filament tidak menyuntik "order by id"
    protected function applySortingToTableQuery(Builder $query): Builder
    {
        // kosongkan agar tidak ada ORDER BY tambahan
        return $query;
    }

    protected function getTableQuery(): Builder
    {
        return BarangMasuk::query()
            ->reorder() // hapus order bawaan Eloquent
            ->selectRaw("
                DATE_FORMAT(created_at, '%M %Y') as bulan,
                MIN(id) as min_id,
                ANY_VALUE(id) as id
            ")
            ->groupByRaw("DATE_FORMAT(created_at, '%M %Y')")
            ->orderByRaw('MIN(created_at), ANY_VALUE(id) ASC');
    }

    public function getTableRecordKey($record): string
    {
        if (isset($record->bulan) && !empty($record->bulan)) {
            $key = 'month_' . $record->bulan;

            if (isset($record->min_id) && !empty($record->min_id)) {
                $key .= '_' . $record->min_id;
            }

            return $key;
        }

        return uniqid('comparison_', true);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('bulan')->label('Bulan'),

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

