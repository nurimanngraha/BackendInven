<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    // Mengaitkan Resource ini dengan Model User
    protected static ?string $model = User::class;

    // Ikon untuk navigasi
    protected static ?string $navigationIcon = 'heroicon-o-users';

    // Label yang terlihat di sidebar
    protected static ?string $modelLabel = 'Pengguna';
    protected static ?string $pluralModelLabel = 'Daftar Pengguna';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Pengguna')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('email')
                    ->label('Alamat Email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true) // Pastikan email unik, abaikan record saat ini saat edit
                    ->maxLength(255),

                // KOMPONEN PASSWORD YANG DIPERBAIKI
                Forms\Components\TextInput::make('password')
                    ->label('Kata Sandi')
                    ->password()
                    // Menggunakan Hash::make untuk mengenkripsi password saat disimpan
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                    // Kolom ini hanya wajib diisi saat operasi 'create' (membuat user baru)
                    ->required(fn (string $operation): bool => $operation === 'create')
                    // Kolom ini hanya terlihat saat operasi 'create' (membuat user baru)
                    ->visibleOn('create') 
                    ->maxLength(255),

                // Catatan: Jika Anda ingin mengizinkan perubahan password saat edit, 
                // Anda harus menambahkan komponen password lain dengan required(false) 
                // dan menambahkan logika dehydrateStateUsing yang berbeda untuk handle edit.
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Filter yang mungkin menyebabkan masalah user Gmail Anda, 
                // tetapi di sini dikosongkan secara default. 
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
