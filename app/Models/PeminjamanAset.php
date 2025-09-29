<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeminjamanAset extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_aset';

    protected $fillable = [
        'aset_id',
        'peminjam',
        'bagian',
        'tanggal_pinjam',
        'tanggal_kembali',
        'jumlah',
        'sisa_stok',
        'status',
    ];

    public function aset()
    {
        return $this->belongsTo(Aset::class, 'aset_id');
    }
}
