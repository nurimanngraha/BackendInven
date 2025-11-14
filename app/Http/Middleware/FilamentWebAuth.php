<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class FilamentWebAuth
{
    public function handle($request, Closure $next)
    {
        // Jika user belum login Laravel (guard web), arahkan ke login publik
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Kalau sudah login, lanjut ke Filament
        return $next($request);
    }
}
