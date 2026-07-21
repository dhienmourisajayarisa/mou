<?php

use App\Http\Controllers\MusicController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Halaman awal langsung diarahkan ke login bawaan Breeze
Route::get('/', function () {
    return redirect()->route('login');
});

// Semua halaman di bawah ini wajib LOGIN dulu baru bisa dibuka
Route::middleware(['auth'])->group(function () {
    
    // 1. Jalur halaman musik untuk Pengguna Biasa
    Route::get('/music', [MusicController::class, 'index'])->name('music.index');
    
    // Redirect dashboard bawaan breeze ke halaman musik kamu
    Route::get('/dashboard', function () {
        return redirect('/music');
    })->name('dashboard');

    // 2. Jalur khusus ADMIN UTAMA (Menggunakan middleware admin bawaanmu)
    Route::middleware(['admin'])->group(function () {
        // Halaman utama dashboard admin (Tabel lagu)
        Route::get('/super-admin', [AdminController::class, 'index'])->name('admin.index');
        
        // PROSES SIMPAN (Sudah diarahkan dengan benar ke AdminController)
        Route::post('/super-admin', [AdminController::class, 'store'])->name('admin.store');
        
        // Tambahan rute untuk fitur Edit dan Hapus biar sekalian aktif dan tidak eror nanti
        Route::get('/super-admin/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
        Route::put('/super-admin/{id}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/super-admin/{id}', [AdminController::class, 'destroy'])->name('admin.delete');
    });

});

require __DIR__.'/auth.php';