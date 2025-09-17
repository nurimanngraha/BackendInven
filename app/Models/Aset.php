<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aset extends Model
{
    use HasFactory;

    protected $table = 'asets';

    protected $fillable = [
        'nama_aset',
        'kategori',
        'jumlah',
    ];

    /**
     * Relasi ke tabel peminjaman_asets
     * Satu aset bisa punya banyak peminjaman
     */
    public function peminjamanAsets()
    {
        return $this->hasMany(PeminjamanAset::class, 'aset_id');
    }
}
