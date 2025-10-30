<?php


// app/Http/Controllers/StokOpnameController.php
namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\StokOpname;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StokOpnameController extends Controller
{
    /**
     * Cari aset dari QR string (misalnya hasil kamera / input manual)
     */
    public function findByQr(Request $request)
    {
        $request->validate([
            'qr' => 'required|string',
        ]);

        $qr = $request->qr;

        // ASUMSI: nilai QR == kolom 'id' di tabel asets (kode aset unik)
        // Kalau kamu punya kolom lain, ganti 'id' jadi kolom itu
        $aset = Aset::where('id', $qr)->first();

        if (!$aset) {
            return response()->json([
                'found' => false,
                'message' => 'Aset tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'found' => true,
            'aset' => [
                'id'         => $aset->id,             // kode aset
                'nama_aset'  => $aset->nama_aset ?? $aset->nama ?? 'Aset',
                'merk_kode'  => $aset->merk_kode ?? $aset->merk ?? '-',
                'status'     => $aset->status ?? 'OK', // misal: Aktif / Rusak / Dipinjam
            ],
        ]);
    }

    /**
     * Upload foto QR, server decode pakai library, lalu balikin data aset
     */
    public function decodeUpload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:4096',
        ]);

        $imgPath = $request->file('image')->getRealPath();

        $qrcode = new \Zxing\QrReader($imgPath);
        $decodedText = $qrcode->text();

        if (!$decodedText) {
            return response()->json([
                'found' => false,
                'message' => 'QR tidak terbaca',
            ], 422);
        }

        $aset = Aset::where('id', $decodedText)->first();

        return response()->json([
            'qr'    => $decodedText,
            'found' => (bool) $aset,
            'aset'  => $aset ? [
                'id'         => $aset->id,
                'nama_aset'  => $aset->nama_aset ?? $aset->nama ?? 'Aset',
                'merk_kode'  => $aset->merk_kode ?? $aset->merk ?? '-',
                'status'     => $aset->status ?? 'OK',
            ] : null,
            'message' => $aset ? null : 'Aset tidak ditemukan',
        ]);
    }

    /**
     * Simpan hasil opname (log)
     * + opsional update status aset sekarang
     */
    public function store(Request $request)
    {
        $request->validate([
            'aset_id' => 'required|string|exists:asets,id',
            'qty'     => 'required|integer|min:1',
            'status'  => 'required|in:OK,RUSAK,HILANG,LAINNYA',
            'note'    => 'nullable|string|max:500',
        ]);

        $aset = Aset::findOrFail($request->aset_id);

        // catat log opname
        $opname = StokOpname::create([
            'aset_id' => $aset->id,
            'qty'     => $request->qty,
            'status'  => $request->status,
            'meta'    => [
                'note' => $request->note,
            ],
            'user_id' => Auth::id(),
        ]);

        // opsional: update status aset langsung.
        // jika kamu mau mapping:
        //   OK      -> 'Aktif'
        //   RUSAK   -> 'Rusak'
        //   HILANG  -> 'Hilang' / 'Tidak ada'
        //   LAINNYA -> biarkan apa adanya
        $mapBaruKeAset = [
            'OK'     => 'Aktif',
            'RUSAK'  => 'Rusak',
            'HILANG' => 'Hilang',
        ];

        if ($request->status !== 'LAINNYA') {
            $aset->update([
                'status' => $mapBaruKeAset[$request->status] ?? $aset->status,
            ]);
        }

        return response()->json([
            'ok'         => true,
            'opname_id'  => $opname->id,
            'message'    => 'Opname tersimpan',
        ]);
    }
}
