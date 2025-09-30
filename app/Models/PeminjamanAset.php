<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeminjamanAset extends Model
{
    protected $table = 'peminjaman_aset'; // singular

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

    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }
}
