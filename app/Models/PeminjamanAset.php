<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeminjamanAset extends Model
{
    use HasFactory;

    protected $fillable = [
        'aset_id',
        'peminjam',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];

    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }
}
