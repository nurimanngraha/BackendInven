<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrLabelController extends Controller
{
    /** Tampilkan label QR 1 aset; auto-generate QR jika belum ada */
    public function label(Aset $aset)
    {
        Storage::disk('public')->makeDirectory('qr/aset');

        if (blank($aset->qr_path) || ! Storage::disk('public')->exists($aset->qr_path)) {
            // payload QR: URL scan + SN11 (atau fallback ke code|serial)
            $url = route('assets.scan.show', ['code' => $aset->code], false);
            $payload = $url ? $url.'?n='.$aset->serial_11 : ($aset->code.'|'.$aset->serial_11);

            $svg = QrCode::format('svg')->size(600)->margin(1)->generate($payload);

            $path = "qr/aset/{$aset->code}.svg";
            Storage::disk('public')->put($path, $svg);

            $aset->forceFill(['qr_path' => $path])->save();
        }

        return view('assets.label', ['aset' => $aset]);
    }
}
    