<?php

namespace App\Filament\Widgets;

use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;

class BarangComparisonTable extends BaseWidget
{
    protected static ?string $heading = 'Tabel Perbandingan Barang Masuk & Keluar';

    // Lebarnya setengah layar, biar tidak full
    protected int|string|array $columnSpan = 6;

    public function table(Tables\Table $table): Tables\Table
    {
        $data = collect([
            ['jenis' => 'Barang Masuk', 'total' => BarangMasuk::count()],
            ['jenis' => 'Barang Keluar', 'total' => BarangKeluar::count()],
        ]);

        return $table
            ->query(
                fn () => \App\Models\BarangMasuk::query()->limit(0) // dummy query biar tidak error
            )
            ->columns([
                Tables\Columns\TextColumn::make('jenis')
                    ->label('Jenis')
                    ->getStateUsing(fn ($record, $state, $rowLoop) => $data[$rowLoop->index]['jenis'] ?? ''),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->getStateUsing(fn ($record, $state, $rowLoop) => $data[$rowLoop->index]['total'] ?? 0),
            ])
            ->paginated(false); // biar tidak ada pagination
    }
}
