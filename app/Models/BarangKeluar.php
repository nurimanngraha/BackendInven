<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangKeluar extends Model
{
    use HasFactory;

    protected $table = 'barang_keluars';

    protected $fillable = [
        'no_transaksi',
        'barang_id',
        'tanggal_keluar',
        'jumlah',
        'penerima',
        'bagian',
        'petugas',
    ];

    /**
     * Relasi ke Barang
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    /**
     * Auto generate No Transaksi
     * Format: T-BK-YYMMDD0001
     */
    protected static function booted()
    {
        static::creating(function ($barangKeluar) {
            $prefix = 'T-BK-';
            $datePart = now()->format('ymd'); // contoh: 250801

            // cari transaksi terakhir di hari ini
            $lastTransaksi = self::whereDate('created_at', now())
                ->orderBy('id', 'desc')
                ->first();

            if ($lastTransaksi) {
                $lastNumber = (int) substr($lastTransaksi->no_transaksi, -4);
                $nextNumber = $lastNumber + 1;
            } else {
                $nextNumber = 1;
            }

            // set no_transaksi
            $barangKeluar->no_transaksi = $prefix . $datePart . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        });
    }
}
