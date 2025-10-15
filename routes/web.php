<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\QrLabelController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PublicAuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// ========== ROUTE LUPA PASSWORD ==========
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// ========== ROUTE AUTH PUBLIC ==========
Route::get('/login', [PublicAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [PublicAuthController::class, 'login'])->name('login.post');
Route::get('/register', [RegisterController::class, 'showForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register.store');

Route::post('/admin/logout', function () {
    Auth::guard('web')->logout();
    return redirect('/login');
})->name('filament.admin.auth.logout');

Route::any('/admin/login', function () {
    return redirect('/login');
});


// ========== ROOT TEST ==========
Route::get('/', fn () => 'OK ROOT');

// ========== TEST QR ==========
Route::get('/test-qr', function () {
    if (! file_exists(public_path('storage'))) {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
    }

    Storage::disk('public')->makeDirectory('qr');

    $svg = QrCode::format('svg')->size(300)->margin(1)->generate('HELLO-QR');
    Storage::disk('public')->put('qr/test.svg', $svg);

    return '<a href="'.asset('storage/qr/test.svg').'" target="_blank">Buka QR (SVG)</a>';
});

// ========== CETAK QR ==========
Route::get('/assets/{aset}/label', [QrLabelController::class, 'label'])
    ->name('assets.print');

// ========== SCAN QR ==========
Route::get('/scan/{code}', function (string $code) {
    $n = request('n');
    return "Scan OK. CODE={$code} SN11={$n}";
})->name('assets.scan.show');

// ========== TEST KIRIM EMAIL ==========
Route::get('/test-mail', function () {
    try {
        Mail::raw('Ini adalah email percobaan dari Laravel!', function ($message) {
            $message->to('dihsan1818@gmail.com') // ⬅️ Ganti dengan email kamu
                    ->subject('Tes Kirim Email Laravel');
        });

        return '✅ Email berhasil dikirim. Cek inbox (atau folder spam).';
    } catch (\Exception $e) {
        return '❌ Gagal mengirim email: ' . $e->getMessage();
    }
});
