<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangKeluar extends Model
{
    use HasFactory;

    // pakai default naming convention Laravel → otomatis "barang_keluars"
    // jadi $table tidak perlu di-set, hapus saja

    protected $fillable = [
        'no_transaksi',
        'barang_id',
        'jumlah',
        'tanggal_keluar',
        'penerima',
        'bagian',
        'petugas',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
