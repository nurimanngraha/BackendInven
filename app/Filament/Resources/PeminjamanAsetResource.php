<?php

namespace App\Filament\Resources;

use App\Models\PeminjamanAset;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\PeminjamanAsetResource\Pages;
use Barryvdh\DomPDF\Facade\Pdf;

class PeminjamanAsetResource extends Resource
{
    protected static ?string $model = PeminjamanAset::class;

    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationLabel = 'Peminjaman Aset';

    public static function getModelLabel(): string
    {
        return 'Peminjaman Aset';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Peminjaman Aset';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('aset_id')
                ->relationship('aset', 'nama_aset')
                ->required()
                ->label('Nama Barang'),

            Forms\Components\TextInput::make('peminjam')
                ->required()
                ->label('Peminjam'),

            Forms\Components\TextInput::make('bagian')
                ->label('Bagian / Departemen'),

            Forms\Components\DatePicker::make('tanggal_pinjam')
                ->required()
                ->label('Tanggal Pinjam'),

            Forms\Components\DatePicker::make('tanggal_kembali')
                ->label('Tanggal Kembali')
                ->nullable(),

            Forms\Components\TextInput::make('jumlah')
                ->numeric()
                ->default(1)
                ->required()
                ->label('Jumlah'),

            Forms\Components\Select::make('status')
                ->options([
                    'Dipinjam' => 'Dipinjam',
                    'Dikembalikan' => 'Dikembalikan',
                ])
                ->default('Dipinjam')
                ->label('Status'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('aset.nama_aset')
                    ->label('Aset')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('peminjam')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bagian')
                    ->label('Bagian')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlah')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.') . ' unit')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_pinjam')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_kembali')
                    ->date('d M Y')
                    ->label('Tanggal Kembali')
                    ->placeholder('-')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'Dipinjam',
                        'success' => 'Dikembalikan',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Dipinjam' => 'Dipinjam',
                        'Dikembalikan' => 'Dikembalikan',
                    ]),
                Tables\Filters\Filter::make('tanggal_pinjam')
                    ->form([
                        Forms\Components\DatePicker::make('dari_tanggal')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('sampai_tanggal')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['dari_tanggal'], fn ($q) => $q->whereDate('tanggal_pinjam', '>=', $data['dari_tanggal']))
                            ->when($data['sampai_tanggal'], fn ($q) => $q->whereDate('tanggal_pinjam', '<=', $data['sampai_tanggal']));
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    
                    Tables\Actions\Action::make('kembalikan')
                        ->label('Kembalikan')
                        ->icon('heroicon-o-arrow-uturn-left')
                        ->color('success')
                        ->requiresConfirmation()
                        ->visible(fn ($record) => $record->status === 'Dipinjam')
                        ->action(fn ($record) => $record->update([
                            'status' => 'Dikembalikan',
                            'tanggal_kembali' => now(),
                        ])),
                    
                    // ✅ FIXED: Print Single Record dengan DomPDF
                    Tables\Actions\Action::make('print')
                        ->label('Cetak')
                        ->icon('heroicon-o-printer')
                        ->color('primary')
                        ->action(function (PeminjamanAset $record) {
                            $pdf = Pdf::loadHTML(
                                view('pdf.peminjaman-aset-single', ['record' => $record])
                            );
                            
                            return response()->streamDownload(
                                fn () => print($pdf->output()),
                                "peminjaman-aset-{$record->id}.pdf"
                            );
                        }),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    
                    Tables\Actions\BulkAction::make('kembalikan')
                        ->label('Kembalikan Selected')
                        ->icon('heroicon-o-arrow-uturn-left')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            $records->each(function ($record) {
                                if ($record->status === 'Dipinjam') {
                                    $record->update([
                                        'status' => 'Dikembalikan',
                                        'tanggal_kembali' => now(),
                                    ]);
                                }
                            });
                        }),
                    
                    // ✅ FIXED: Bulk Print dengan DomPDF
                    Tables\Actions\BulkAction::make('print')
                        ->label('Cetak Selected')
                        ->icon('heroicon-o-printer')
                        ->color('primary')
                        ->action(function (Collection $records) {
                            $pdf = Pdf::loadHTML(
                                view('pdf.peminjaman-aset-bulk', [
                                    'records' => $records,
                                    'tanggal' => now()->format('d F Y')
                                ])
                            );
                            
                            return response()->streamDownload(
                                fn () => print($pdf->output()),
                                'laporan-peminjaman-aset.pdf'
                            );
                        }),
                ]),
            ])
            ->headerActions([
                // ✅ FIXED: Print All dengan DomPDF
                Tables\Actions\Action::make('printAll')
                    ->label('Cetak Semua')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    ->action(function () {
                        $records = PeminjamanAset::with('aset')->get();
                        
                        $pdf = Pdf::loadHTML(
                            view('pdf.peminjaman-aset-bulk', [
                                'records' => $records,
                                'tanggal' => now()->format('d F Y')
                            ])
                        );
                        
                        return response()->streamDownload(
                            fn () => print($pdf->output()),
                            'laporan-semua-peminjaman-aset.pdf'
                        );
                    }),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPeminjamanAset::route('/'),
            'create' => Pages\CreatePeminjamanAset::route('/create'),
            'edit'   => Pages\EditPeminjamanAset::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}