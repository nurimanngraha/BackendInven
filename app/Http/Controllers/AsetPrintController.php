<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use Illuminate\Http\Request;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;

class AsetPrintController extends Controller
{
    // dipakai kalau kamu mau akses langsung /admin/asets/{aset}/print-direct
    public function showDirect(Aset $aset)
    {
        return $this->renderPreviewView($aset);
    }

    // dipakai tombol Print dari modal (menggunakan session aset terakhir)
    public function preview(Request $request)
    {
        $pk = $request->session()->get('last_print_aset_pk');

        if (!$pk) {
            abort(404, 'Tidak ada aset yang dipilih.');
        }

        $aset = Aset::find($pk);

        if (!$aset) {
            abort(404, 'Aset tidak ditemukan.');
        }

        return $this->renderPreviewView($aset);
    }

    /**
     * Render view preview cetak.
     * Di sini kita siapkan data awal (payload aset dan QR-size default),
     * tapi TIDAK langsung print. Print akan dipicu oleh tombol di halaman.
     */
    private function renderPreviewView(Aset $aset)
{
    // gunakan kode_scan (prioritas). kalau tidak ada, fallback ke id.
    $payload = (string) ($aset->kode_scan ?? $aset->id ?? '');

    // generate QR default size (misal 200px) untuk pertama kali load halaman preview
    $defaultSize = 200;

    $svg = $this->generateQrSvg($payload, $defaultSize);

    return view('print.preview', [
        'aset'        => $aset,
        'payload'     => $payload,
        'defaultSize' => $defaultSize,
        'svg'         => $svg,
    ]);
}


    /**
     * Helper internal untuk bikin QR SVG dgn ukuran tertentu
     */
    private function generateQrSvg(string $payload, int $size): string
    {
        $renderer = new ImageRenderer(
            new RendererStyle(
                $size, // px
                0      // margin putih
            ),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        return $writer->writeString($payload);
    }
}
