<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StokOpnameResource\Pages;
use App\Models\StokOpname;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StokOpnameResource extends Resource
{
    protected static ?string $model = StokOpname::class;

    // INI PENTING:
    // Kita matiin menu default resource ini dari sidebar
    // supaya operator gudang tidak diarahkan ke halaman index ini.
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon  = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?string $navigationLabel = 'Log Stock Opname';
    protected static ?string $pluralModelLabel = 'Stok Opnames';

    public static function form(Form $form): Form
    {
        // Form ini dipakai kalau kamu mau tambah/edit manual.
        // Sebenernya untuk log opname kita gak perlu create/edit dari UI,
        // karena datanya di-generate dari halaman scan. Jadi ini bisa dibiarkan basic.

        return $form->schema([
            Forms\Components\Select::make('aset_id')
                ->relationship('aset', 'nama_aset') // atau kolom yang paling jelas buat dibaca
                ->required()
                ->label('Aset'),

            Forms\Components\TextInput::make('status_fisik')
                ->required()
                ->label('Status Fisik (hasil opname)'),

            Forms\Components\Textarea::make('catatan')
                ->rows(2)
                ->label('Catatan'),

            Forms\Components\DateTimePicker::make('checked_at')
                ->required()
                ->label('Dicek pada'),

            Forms\Components\Select::make('checked_by')
                ->relationship('checker', 'name') // sesuaikan kalau user model kamu pakai kolom 'name'
                ->required()
                ->label('Pengecek'),
        ]);
    }

    public static function table(Table $table): Table
    {
        // Ini tabel yang akan muncul kalau kamu buka Resource ini (mis: /admin/stok-opnames).
        // Ini berguna banget buat audit nanti, walaupun gak kita tampilkan di sidebar untuk operator.

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('aset.id9')
                    ->label('Kode Aset')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('aset.nama_aset')
                    ->label('Nama Aset')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('status_fisik')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match (strtolower($state)) {
                        'ok'       => 'success',
                        'rusak'    => 'danger',
                        'hilang'   => 'warning',
                        'dipinjam' => 'gray',
                        default    => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('catatan')
                    ->label('Catatan')
                    ->limit(30)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('checked_at')
                    ->label('Waktu Cek')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('checker.name')
                    ->label('Dicek oleh')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('checked_at', 'desc')
            ->filters([
                // Contoh filter kalau mau:
                // Tables\Filters\SelectFilter::make('status_fisik')
                //     ->options([
                //         'OK'       => 'OK',
                //         'Rusak'    => 'Rusak',
                //         'Hilang'   => 'Hilang',
                //         'Dipinjam' => 'Dipinjam',
                //     ]),
            ])
            ->actions([
                // Karena ini cuma log, kita bisa matikan edit & delete di sini.
                // Kalau mau read-only penuh, biarkan kosong.
            ])
            ->bulkActions([
                // kosongin juga agar user tidak bisa bulk delete
            ]);
    }

    public static function getPages(): array
    {
        return [
            // ini adalah halaman index bawaan Resource
            'index' => Pages\ListStokOpnames::route('/'),
            // kalau generator bikin Create / Edit, kamu boleh hapus route-nya
            // karena log ini harusnya datang dari scanning, bukan input manual:
            // 'create' => Pages\CreateStokOpname::route('/create'),
            // 'edit'   => Pages\EditStokOpname::route('/{record}/edit'),
        ];
    }
}
