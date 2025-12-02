<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\AccountCreatedMail;

class PublicAuthController extends Controller
{
    // ====== TAMPIL HALAMAN LOGIN ======
    public function showLogin()
    {
        return view('public.login');
    }

    // ====== PROSES LOGIN ======
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // ✅ Regenerasi & simpan session segera
            $request->session()->regenerate();

            // ✅ Langsung ke dashboard
            return redirect()->intended('/admin');
        }

        return back()->with('error', 'Email atau password salah.');
    }

    // ====== TAMPIL HALAMAN REGISTER ======
    public function showRegister()
    {
        return view('public.register');
    }

    // ====== PROSES REGISTER ======
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        // ✅ Buat akun baru
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        try {
            // ✅ Kirim email notifikasi akun baru
            Mail::to($user->email)->send(new AccountCreatedMail($user));
        } catch (\Exception $e) {
            Log::error('Gagal mengirim email registrasi: ' . $e->getMessage());
        }

        // ✅ Arahkan ke login (tidak langsung masuk dashboard)
        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login terlebih dahulu.');
    }

    // ====== LOGOUT TAMBAHAN (FIX TANPA MENGGANGGU LOGIC LAIN) ======
    public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
}

}