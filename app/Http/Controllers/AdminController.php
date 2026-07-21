<?php

namespace App\Http\Controllers;

use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $tracks = Track::latest()->get(); 
        return view('admin', compact('tracks')); 
    }

    // 1. PROSES SIMPAN (STORE)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'audio_file' => 'required|file|max:30720',
            'cover_file' => 'nullable|image|max:10240',
            'lrc_file' => 'nullable|file|max:2048', // Validasi file lrc (maksimal 2MB)
            'lyrics' => 'nullable|string',
        ]);

        $data = $request->only(['title', 'artist', 'lyrics']);

        if ($request->hasFile('audio_file')) {
            $audioPath = $request->file('audio_file')->store('tracks/audio', 'public');
            $data['audio_url'] = Storage::url($audioPath);
        }

        if ($request->hasFile('cover_file')) {
            $coverPath = $request->file('cover_file')->store('tracks/cover', 'public');
            $data['cover_url'] = Storage::url($coverPath);
        }

        // Upload file lrc (jika ada)
        if ($request->hasFile('lrc_file')) {
            $lrcPath = $request->file('lrc_file')->store('tracks/lrc', 'public');
            $data['lrc_file'] = Storage::url($lrcPath);
        }

        Track::create($data);

        return redirect()->route('admin.index')->with('success', 'Lagu baru berhasil disimpan!');
    }

    public function edit($id)
    {
        $track = Track::findOrFail($id);
        $tracks = Track::latest()->get();
        return view('admin', compact('track', 'tracks'));
    }

    // 2. PROSES PERBARUI (UPDATE)
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'audio_file' => 'nullable|file|max:30720',
            'cover_file' => 'nullable|image|max:10240',
            'lrc_file' => 'nullable|file|max:2048',
            'lyrics' => 'nullable|string',
        ]);

        $track = Track::findOrFail($id);
        
        $data = [
            'title' => $request->title,
            'artist' => $request->artist,
            'lyrics' => $request->lyrics,
            'audio_url' => $track->audio_url, 
            'cover_url' => $track->cover_url, 
            'lrc_file' => $track->lrc_file, 
        ];

        if ($request->hasFile('audio_file')) {
            if ($track->audio_url) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $track->audio_url));
            }
            $audioPath = $request->file('audio_file')->store('tracks/audio', 'public');
            $data['audio_url'] = Storage::url($audioPath);
        }

        if ($request->hasFile('cover_file')) {
            if ($track->cover_url) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $track->cover_url));
            }
            $coverPath = $request->file('cover_file')->store('tracks/cover', 'public');
            $data['cover_url'] = Storage::url($coverPath);
        }

        // Jika ada file .lrc baru yang diupload
        if ($request->hasFile('lrc_file')) {
            if ($track->lrc_file) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $track->lrc_file));
            }
            $lrcPath = $request->file('lrc_file')->store('tracks/lrc', 'public');
            $data['lrc_file'] = Storage::url($lrcPath);
        }

        $track->update($data);

        return redirect()->route('admin.index')->with('success', 'Lagu berhasil diperbarui!');
    }

    // 3. PROSES HAPUS (DESTROY)
    public function destroy($id)
    {
        $track = Track::findOrFail($id);

        if ($track->audio_url) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $track->audio_url));
        }
        if ($track->cover_url) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $track->cover_url));
        }
        if ($track->lrc_file) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $track->lrc_file));
        }

        $track->delete();

        return redirect()->back()->with('success', 'Lagu berhasil dihapus!');
    }
}