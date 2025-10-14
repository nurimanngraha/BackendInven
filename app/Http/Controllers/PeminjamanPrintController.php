<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanAset;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PeminjamanPrintController extends Controller
{
    public function print(PeminjamanAset $peminjaman)
    {
        $pdf = Pdf::loadView('peminjaman.print-single', compact('peminjaman'));
        return $pdf->download('peminjaman-aset-' . $peminjaman->id . '.pdf');
    }

    public function bulkPrint(Request $request)
    {
        $ids = explode(',', $request->ids);
        $peminjaman = PeminjamanAset::whereIn('id', $ids)->with('aset')->get();
        
        $pdf = Pdf::loadView('peminjaman.print-bulk', compact('peminjaman'));
        return $pdf->download('peminjaman-aset-selected.pdf');
    }

    public function printAll(Request $request)
    {
        $peminjaman = PeminjamanAset::with('aset')->get();
        
        $pdf = Pdf::loadView('peminjaman.print-all', compact('peminjaman'));
        return $pdf->download('semua-peminjaman-aset.pdf');
    }
}