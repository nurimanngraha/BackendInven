<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log; // ✅ tambahkan ini
use App\Mail\AccountCreatedMail;

class PublicAuthController extends Controller
{
    public function showLogin()
    {
        return view('public.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            // ✅ Login berhasil → langsung ke dashboard admin (sementara)
            return redirect()->intended('/admin');
        }

        return back()->with('error', 'Email atau password salah.');
    }

    public function showRegister()
    {
        return view('public.register');
    }

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
            Log::error('Gagal mengirim email registrasi: '.$e->getMessage());
        }

        // ✅ Redirect ke halaman login
        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan cek email Anda.');
    }
}
