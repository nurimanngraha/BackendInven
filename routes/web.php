<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail; 
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\QrLabelController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\PublicAuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\AsetPrintController;

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
// Route::get('/test-qr', function () {
//     if (! file_exists(public_path('storage'))) {
//         Artisan::call('storage:link');
//     }

//     Storage::disk('public')->makeDirectory('qr');

//     $svg = QrCode::format('svg')->size(300)->margin(1)->generate('HELLO-QR');
//     Storage::disk('public')->put('qr/test.svg', $svg);

//     return '<a href="'.asset('storage/qr/test.svg').'" target="_blank">Buka QR (SVG)</a>';
// // });

// // ========== CETAK QR ==========
// Route::get('/assets/{aset}/label', [QrLabelController::class, 'label'])
//     ->name('assets.print'); // <-- ini yang dipanggil dari Filament

Route::get('/admin/asets/{aset}/print-direct', [AsetPrintController::class, 'showDirect'])
    ->name('assets.print.direct')
    ->middleware(['auth']);

Route::get('/admin/asets/print-current', [AsetPrintController::class, 'preview'])
    ->name('assets.print')
    ->middleware(['auth']);



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
