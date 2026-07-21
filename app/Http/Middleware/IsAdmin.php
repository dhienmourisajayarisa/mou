<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login
        // 2. Cek apakah email yang login adalah email admin utama kamu
        if (Auth::check() && Auth::user()->email === 'admin@multihub.com') {
            return $next($request); // Jika benar admin, dipersilakan masuk
        }

        // Jika bukan admin, arahkan balik ke halaman musik dengan pesan error
        return redirect('/music')->with('error', 'Kamu bukan admin! Akses ditolak.');
    }
}