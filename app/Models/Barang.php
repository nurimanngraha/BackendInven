<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang',
        'jenis_barang',
        'stok',
        'satuan',
    ];

    public function masuk()
    {
        return $this->hasMany(BarangMasuk::class, 'barang_id');
    }

    public function keluar()
    {
        return $this->hasMany(BarangKeluar::class, 'barang_id');
    }
}
