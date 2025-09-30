<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeminjamanAset extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'peminjaman_aset';

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'aset_id',
        'peminjam',
        'bagian',
        'tanggal_pinjam',
        'tanggal_kembali',
        'jumlah',
        'sisa_stok',
        'status',
        'keterangan',
    ];

    // Relasi ke model Aset
    public function aset()
    {
        return $this->belongsTo(Aset::class, 'aset_id');
    }
}
