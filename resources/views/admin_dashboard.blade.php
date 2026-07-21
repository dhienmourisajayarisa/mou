<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Musik</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #121212; color: #ffffff; margin: 0; padding: 20px; display: flex; gap: 20px; justify-content: center; }
        .panel { background: #1e1e1e; border-radius: 15px; padding: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.5); }
        #player-side { width: 100%; max-width: 450px; }
        #form-side { width: 100%; max-width: 350px; }
        input[type="text"] { width: 100%; padding: 10px; background: #282828; border: 1px solid #444; border-radius: 5px; color: white; margin-bottom: 10px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #1db954; border: none; color: white; font-weight: bold; border-radius: 5px; cursor: pointer; }
        .logout-btn { background: #cc0000; margin-top: 15px; }
        .playlist-item { display: flex; justify-content: space-between; background: #282828; padding: 10px; margin-bottom: 5px; border-radius: 5px; }
    </style>
</head>
<body>

<div id="player-side" class="panel">
    <h2>Selamat Datang, Admin!</h2>
    <h3>Daftar Lagu Terpasang</h3>
    <ul style="list-style: none; padding: 0;">
        @forelse($tracks as $track)
            <li class="playlist-item">
                <div>
                    <strong>{{ $track->title }}</strong> <br>
                    <small style="color: #aaa;">{{ $track->artist }}</small>
                </div>
            </li>
        @empty
            <p style="color: #888;">Belum ada lagu.</p>
        @endforelse
    </ul>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-btn">Log Out</button>
    </form>
</div>

<div id="form-side" class="panel">
    <h3 style="color: #1db954;">Tambah Musik Baru</h3>
    <form action="{{ route('admin.store') }}" method="POST">
        @csrf
        <label>Judul Lagu</label>
        <input type="text" name="title" required>

        <label>Nama Artis</label>
        <input type="text" name="artist" required>

        <label>Link Audio URL (MP3)</label>
        <input type="text" name="audio_url" required>

        <label>Link Cover URL</label>
        <input type="text" name="cover_url">

        <button type="submit">Unggah ke Web</button>
    </form>
</div>

</body>
</html>