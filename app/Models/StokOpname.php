<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokOpname extends Model
{
    protected $fillable = [
        'aset_id',
        'barcode',
        'stok_sistem',
        'stok_fisik',
        'selisih',
        'status',
    ];

    // Relasi ke aset
    public function aset()
    {
        return $this->belongsTo(Aset::class);
    }

    // Booted: hitung selisih hanya jika stok_fisik berubah
    protected static function booted()
    {
        static::saving(function ($stokOpname) {
            if ($stokOpname->isDirty('stok_fisik')) {
                $stokOpname->selisih = $stokOpname->stok_fisik - $stokOpname->stok_sistem;
            }
        });
    }

    // Mutator: barcode selalu uppercase
    public function setBarcodeAttribute($value)
    {
        $this->attributes['barcode'] = strtoupper($value);
    }

    // Accessor: selisih dengan tanda + / -
    public function getSelisihFormattedAttribute()
    {
        $selisih = $this->selisih;
        return ($selisih >= 0 ? '+' : '') . $selisih;
    }

    // Helper cek status OK
    public function isOk(): bool
    {
        return $this->status === 'ok';
    }

    // Helper cek status Rusak
    public function isRusak(): bool
    {
        return $this->status === 'rusak';
    }
}
