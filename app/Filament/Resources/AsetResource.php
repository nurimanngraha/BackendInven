<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AsetResource\Pages;
use App\Models\Aset;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;                 // row action
use Filament\Actions\Action as ModalAction;         // action di footer modal
use Illuminate\Support\HtmlString;                  // untuk return HTML ke modal
// use SimpleSoftwareIO\QrCode\Facades\QrCode;    
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;


class AsetResource extends Resource
{
    protected static ?string $model = Aset::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationGroup = 'Manajemen Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_aset')
                    ->label('Nama Aset')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('merk_kode')
                    ->label('Merk/Kode')
                    ->maxLength(150),

                Forms\Components\Select::make('kategori')
                    ->label('Kategori')
                    ->options([
                        'Elektronik' => 'Elektronik',
                        'Furniture'  => 'Furniture',
                        'Lainnya'    => 'Lainnya',
                    ])
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'Aktif'    => 'Aktif',
                        'Rusak'    => 'Rusak',
                        'Dipinjam' => 'Dipinjam',
                        'Hilang'   => 'Hilang',
                    ])
                    ->required(),

                Forms\Components\DatePicker::make('log_pembaruan_barcode')
                    ->label('Log Pembaruan Barcode'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                ->label('Id')
                ->getStateUsing(fn (Aset $record) => $record->id9)  // tampilkan accessor id9
                ->sortable('id')                                   // urutkan pakai id asli
                ->searchable(false)                                // (opsional) nonaktifkan search
                ->copyable(),                                    // (opsional) klik untuk salin
                Tables\Columns\TextColumn::make('nama_aset')->label('Nama Aset')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('merk_kode'),
                Tables\Columns\TextColumn::make('kategori'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('log_pembaruan_barcode')->date(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                            // 🟧 Tombol BARCODE (di tengah, antara Edit dan Delete)
                Tables\Actions\Action::make('barcode')
                    ->label('Barcode')
                    ->icon('heroicon-o-qr-code')
                    ->button()
                    ->color('warning')
                    ->modalHeading('Barcode Aset')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->modalWidth('xs')
                    ->modalContent(function (Aset $record) {
                        // Simpan PRIMARY KEY aset ini ke session.
                        // Ini yang dipakai oleh /admin/asets/print-current.
                        session([
                            'last_print_aset_pk' => $record->getKey(),
                        ]);

                        // Ini kode aset yang mau di-QR-kan. Pakai yang benar di sistemmu.
                        $payload = (string) ($record->id9 ?? $record->id ?? '');

                        if ($payload === '') {
                            $svg = '<p style="color:red;font-size:12px">
                                        Kode aset tidak tersedia, tidak bisa buat QR.
                                    </p>';
                        } else {
                            $renderer = new ImageRenderer(
                                new RendererStyle(180, 0),
                                new SvgImageBackEnd()
                            );

                            $writer = new Writer($renderer);

                            try {
                                $svg = $writer->writeString($payload);
                            } catch (\Throwable $e) {
                                $svg = '<p style="color:red;font-size:12px">Gagal generate QR: ' .
                                    e($e->getMessage()) .
                                    '</p>';
                            }
                        }

                        return new HtmlString(<<<HTML
                            <div class="text-center">
                                <div class="inline-block w-[180px] [&>svg]:w-full [&>svg]:h-auto">
                                    {$svg}
                                </div>

                                <div class="mt-1 text-xs text-gray-500 select-all">
                                    {$payload}
                                </div>
                            </div>
                        HTML);
                    })
                    ->extraModalFooterActions([
                        ModalAction::make('preview')
                            ->label('Preview & Cetak')
                            ->icon('heroicon-o-printer')
                            ->color('primary')
                            // tombol ini sekarang buka halaman preview interaktif
                            ->url(route('assets.print'))
                            ->openUrlInNewTab(),
                    ])
                    ->action(fn () => null),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAset::route('/'),
            'create' => Pages\CreateAset::route('/create'),
            'edit'   => Pages\EditAset::route('/{record}/edit'),
        ];
    }

    // 🔹 Tambahan biar singular di sidebar
    public static function getPluralLabel(): string
    {
        return 'Aset';
    }

    public static function getLabel(): string
    {
        return 'Aset';
    }
}
