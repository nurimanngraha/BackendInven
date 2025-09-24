<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    // Supaya mass assignment bisa masuk
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'jenis_barang',
        'satuan',
        'stok',
    ];

    // Atau kalau mau lebih simpel bisa pakai:
    // protected $guarded = [];

    /**
     * Booted model event untuk auto generate kode_barang
     */
    protected static function booted()
    {
        static::creating(function ($barang) {
            // Kalau belum ada kode_barang, generate otomatis
            if (empty($barang->kode_barang)) {
                $lastBarang = self::latest('id')->first();
                $lastNumber = $lastBarang ? intval(substr($lastBarang->kode_barang, 1)) : 0;

                $barang->kode_barang = 'B' . str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
            }
        });
    }
}
