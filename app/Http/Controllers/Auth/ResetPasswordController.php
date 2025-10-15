<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token)
{
    $email = $request->query('email');

    // jika ingin lebih tegas: jika email tidak ada, redirect ke form lupa password
    if (! $email) {
        return redirect()->route('password.request')
            ->with('error', 'Link reset tidak lengkap — coba minta link reset lagi.');
    }

    return view('auth.reset-password', [
        'token' => $token,
        'email' => $email,
    ]);
}


public function reset(Request $request)
{
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password),
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordReset($user));
        }
    );

    if ($status === Password::PASSWORD_RESET) {
        // 🔐 Logout dari semua guard agar tidak bentrok Filament
        \Illuminate\Support\Facades\Auth::guard('web')->logout();
        \Illuminate\Support\Facades\Auth::guard('admin')->logout();

        // 🔒 Bersihkan session sepenuhnya
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ✅ Pastikan redirect ke route login user biasa, bukan Filament
        return redirect()->to(url('/login'))
            ->with('success', 'Password berhasil direset. Silakan login dengan password baru.');
    }

    return back()->withErrors(['email' => [__($status)]]);
    }

}    

