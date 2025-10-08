<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\QrLabelController; // ⬅️ penting: import controller

// Root sederhana untuk cek server hidup
Route::get('/', fn () => 'OK ROOT');

// Route uji generate QR (SVG) — aman tanpa imagick
Route::get('/test-qr', function () {
    if (! file_exists(public_path('storage'))) {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
    }

    Storage::disk('public')->makeDirectory('qr');

    $svg = QrCode::format('svg')->size(300)->margin(1)->generate('HELLO-QR');
    Storage::disk('public')->put('qr/test.svg', $svg);

    return '<a href="'.asset('storage/qr/test.svg').'" target="_blank">Buka QR (SVG)</a>';
});

// Halaman cetak/lihat barcode/QR untuk satu aset
Route::get('/assets/{aset}/label', [QrLabelController::class, 'label'])
    ->name('assets.print');

// Placeholder halaman scan (dipakai sebagai payload QR)
Route::get('/scan/{code}', function (string $code) {
    $n = request('n'); // serial 11 digit
    return "Scan OK. CODE={$code} SN11={$n}";
})->name('assets.scan.show');
