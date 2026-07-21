<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // --- MODIFIKASI DIMULAI DI SINI ---
        // Cek apakah user yang baru saja login adalah admin utama
        if (Auth::user()->email === 'admin@multihub.com') {
            return redirect()->intended('/super-admin');
        }

        // Jika bukan admin (pengguna biasa), arahkan ke RouteServiceProvider::HOME atau langsung ke '/music'
        return redirect()->intended(RouteServiceProvider::HOME);
        // --- MODIFIKASI SELESAI DI SINI ---
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}