<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Log;

class SyncFilamentSession
{
    public function handle(Request $request, Closure $next)
    {
        try {
            // Pastikan session Laravel sudah ditulis sebelum sinkron
            if ($request->hasSession()) {
                $request->session()->save();
            }

            // Jika Laravel logged in tetapi Filament belum -> login Filament
            if (Auth::check() && class_exists(Filament::class) && ! Filament::auth()->check()) {
                $user = Auth::user();
                if ($user && $user instanceof \Illuminate\Contracts\Auth\Authenticatable) {
                    Filament::auth()->login($user);
                }
            }

            // Jika Laravel tidak login tapi Filament masih login -> logout Filament
            if (! Auth::check() && class_exists(Filament::class) && Filament::auth()->check()) {
                Filament::auth()->logout();
            }
        } catch (\Throwable $e) {
            // jangan crash aplikasi, catat saja
            Log::warning('SyncFilamentSession: '.$e->getMessage());
        }

        return $next($request);
    }
}
