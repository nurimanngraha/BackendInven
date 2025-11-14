<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    use HasFactory;

    protected static function boot()
{
    parent::boot();

    static::creating(function ($aset) {

        // --- Pakai kategori_kode atau kode angka yang benar ---
        $kategori = is_numeric($aset->kategori) 
            ? str_pad($aset->kategori, 2, '0', STR_PAD_LEFT)
            : '01'; // fallback angka (jangan huruf)

        // Bulan dan tahun
        $bulan = date('m');
        $tahun = date('y');

        // Nomor urut 3 digit
        $last = Aset::orderBy('id', 'DESC')->first();
        $nextNumber = ($last?->id ?? 0) + 1;
        $urut = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // Kode final
        $aset->kode_scan = $kategori . $bulan . $tahun . $urut;
    });
}



    protected $fillable = [
        'kode_scan',
        'nama_aset',
        'merk_kode',
        'kategori',
        'status',
        'log_pembaruan_barcode',
        'kode_scan',
    ];
    // / Kode 9 digit: CCMMYYNNN /
    public function getId9Attribute(): string
    {
        // 1) Kode kategori 2-digit
        $map = [
            'Elektronik' => '01',
            'Furniture'   => '02',
            'Lainnya'    => '03',
        ];
        $cc = $map[$this->kategori ?? ''] ?? '99'; // fallback 99 bila kategori tak cocok

        // 2) Bulan & tahun pakai created_at (fallback ke now() kalau null)
        $dt = $this->created_at ?: now();
        $mm = $dt->format('m'); // 2 digit
        $yy = $dt->format('y'); // 2 digit

        // 3) Nomor urut (3 digit) untuk kategori & periode yang sama,
        //    dihitung dari jumlah aset dengan id <= current id
        $seq = static::where('kategori', $this->kategori)
            ->whereYear('created_at', $dt->year)
            ->whereMonth('created_at', $dt->month)
            ->where('id', '<=', $this->id ?? 0)
            ->count();

        $nnn = str_pad((string) $seq, 3, '0', STR_PAD_LEFT);

        return "{$cc}{$mm}{$yy}{$nnn}";

        
    }
}
