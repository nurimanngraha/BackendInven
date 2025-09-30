<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_aset',
        'merk_kode',
        'kategori',
        'status',
        'log_pembaruan_barcode',
    ];
}
