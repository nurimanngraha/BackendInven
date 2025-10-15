<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangResource\Pages;
use App\Models\Barang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Dompdf\Dompdf;
use Dompdf\Options;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup = 'Manajemen Data';
    protected static ?string $navigationLabel = 'Data Barang';
    protected static ?string $pluralLabel = 'Data Barang';

    // Form create/edit
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('kode_barang')
                    ->label('ID Barang')
                    ->disabled()
                    ->default(function () {
                        $lastBarang = Barang::latest('id')->first();
                        $lastNumber = $lastBarang ? intval(substr($lastBarang->kode_barang, 1)) : 0;
                        return 'B' . str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
                    }),

                Forms\Components\TextInput::make('nama_barang')
                    ->label('Nama Barang')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('jenis_barang')
                    ->label('Jenis Barang')
                    ->options([
                        'Elektronik' => 'Elektronik',
                        'Furniture' => 'Furniture',
                        'Perlengkapan Kantor' => 'Perlengkapan Kantor',
                        'Aksesoris' => 'Aksesoris',
                        'Alat' => 'Alat',
                        'Bahan' => 'Bahan',
                        'Lainnya' => 'Lainnya',
                    ])
                    ->required(),

                Forms\Components\Select::make('satuan')
                    ->label('Satuan')
                    ->options([
                        'Unit' => 'Unit',
                        'Pcs' => 'Pcs',
                        'Box' => 'Box',
                        'Kg' => 'Kg',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('stok')
                    ->label('Stok')
                    ->numeric()
                    ->required(),
            ]);
    }

    // Table index
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('No')->sortable(),
                Tables\Columns\TextColumn::make('kode_barang')->label('ID Barang')->sortable(),
                Tables\Columns\TextColumn::make('nama_barang')->label('Nama Barang')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('jenis_barang')->label('Jenis Barang'),
                Tables\Columns\TextColumn::make('stok')->label('Stok'),
                Tables\Columns\TextColumn::make('satuan')->label('Satuan'),
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal Input')->dateTime('d/m/Y H:i'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                // Action untuk export single barang ke PDF
                Tables\Actions\Action::make('exportPdf')
                    ->label('PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->action(function (Barang $record) {
                        return static::exportSingleBarangToPdf($record);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    // Bulk action untuk export multiple barang ke PDF
                    Tables\Actions\BulkAction::make('exportPdf')
                        ->label('Export Selected to PDF')
                        ->icon('heroicon-o-document-arrow-down')
                        ->color('success')
                        ->action(function ($records) {
                            return static::exportMultipleBarangToPdf($records);
                        }),
                ]),
            ])
            ->headerActions([
                // Action untuk export semua data ke PDF
                Tables\Actions\Action::make('exportAllPdf')
                    ->label('Export All to PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('danger')
                    ->action(function () {
                        return static::exportAllBarangToPdf();
                    }),
            ]);
    }

    // Relations
    public static function getRelations(): array
    {
        return [];
    }

    // Pages
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBarang::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'edit' => Pages\EditBarang::route('/{record}/edit'),
        ];
    }

    // Auto-generate kode_barang sebelum create
    public static function mutateFormDataBeforeCreate(array $data): array
    {
        $lastBarang = Barang::latest('id')->first();
        $lastNumber = $lastBarang ? intval(substr($lastBarang->kode_barang, 1)) : 0;

        $data['kode_barang'] = 'B' . str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);

        return $data;
    }

    /**
     * Export single barang to PDF
     */
    public static function exportSingleBarangToPdf(Barang $barang)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        
        $dompdf = new Dompdf($options);
        
        $html = view('pdf.barang-single', compact('barang'))->render();
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        $filename = "barang_{$barang->kode_barang}_" . date('Y-m-d_H-i-s') . '.pdf';
        
        return response()->streamDownload(
            function () use ($dompdf) {
                echo $dompdf->output();
            },
            $filename
        );
    }

    /**
     * Export multiple barang to PDF
     */
    public static function exportMultipleBarangToPdf($records)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        
        $dompdf = new Dompdf($options);
        
        $barang = $records;
        $html = view('pdf.barang-multiple', compact('barang'))->render();
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        
        $filename = "barang_multiple_" . date('Y-m-d_H-i-s') . '.pdf';
        
        return response()->streamDownload(
            function () use ($dompdf) {
                echo $dompdf->output();
            },
            $filename
        );
    }

    /**
     * Export all barang to PDF
     */
    public static function exportAllBarangToPdf()
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        
        $dompdf = new Dompdf($options);
        
        $barang = Barang::all();
        $html = view('pdf.barang-all', compact('barang'))->render();
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        
        $filename = "semua_data_barang_" . date('Y-m-d_H-i-s') . '.pdf';
        
        return response()->streamDownload(
            function () use ($dompdf) {
                echo $dompdf->output();
            },
            $filename
        );
    }
}