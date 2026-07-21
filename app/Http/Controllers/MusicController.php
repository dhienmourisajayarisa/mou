<?php

namespace App\Http\Controllers;

use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MusicController extends Controller 
{
    // Halaman Utama setelah Login
    public function index()
    {
        $tracks = Track::all();
        
        // Cek apakah user yang login adalah admin
        if (Auth::user() && Auth::user()->role === 'admin') {
            // Jika admin, arahkan ke halaman khusus admin (bisa tambah lagu)
            return view('admin_dashboard', compact('tracks'));
        }

        // Jika pelanggan biasa, arahkan ke halaman pemutar musik biasa
        return view('music', compact('tracks'));
    }

    // Fungsi menyimpan lagu baru (hanya bisa diakses admin)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'artist' => 'required',
            'audio_url' => 'required',
        ]);

        Track::create([
            'title' => $request->title,
            'artist' => $request->artist,
            'audio_url' => $request->audio_url,
            'cover_url' => $request->cover_url,
        ]);

        return redirect()->back()->with('success', 'Lagu berhasil ditambahkan!');
    }
}