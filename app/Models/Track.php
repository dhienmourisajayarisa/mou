<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory;

    // Pastikan semua kolom ini terdaftar di dalam array fillable!
    protected $fillable = [
        'title', 
        'artist', 
        'audio_url', 
        'cover_url', 
        'lyrics',
        'lrc_file'
    ];
}