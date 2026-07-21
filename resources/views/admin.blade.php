<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-hub: Dashboard Admin Taro</title>
    <style>
        :root {
            --taro-primary: #8B5FBF; /* Ungu Taro Utama */
            --taro-light: #F4EEFF;    /* Ungu Taro Sangat Muda untuk Background */
            --taro-accent: #613A93;   /* Ungu Taro Tua */
            --bg-white: #FFFFFF;      /* Putih Bersih */
            --text-dark: #2B2D42;     /* Warna Teks Gelap */
            --text-muted: #8D99AE;    /* Warna Teks Redup */
            --danger: #E63946;        /* Merah Hapus */
            --warning: #FFA800;       /* Warna Oranye Edit */
        }

        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--taro-light);
            color: var(--text-dark);
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* HEADER */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--bg-white);
            padding: 20px 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(139, 95, 191, 0.1);
            margin-bottom: 30px;
        }

        header h2 {
            margin: 0;
            font-size: 24px;
            color: var(--taro-accent);
        }

        .btn-back {
            background-color: var(--taro-primary);
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 14px;
            transition: 0.3s;
        }

        .btn-back:hover {
            background-color: var(--taro-accent);
        }

        /* SUSUNAN LAYOUT GRID (KIRI & KANAN) */
        .admin-layout {
            display: grid;
            grid-template-columns: 1fr 1.5fr; /* Kiri kolom input, Kanan kolom tabel data */
            gap: 30px;
        }

        @media (max-width: 900px) {
            .admin-layout {
                grid-template-columns: 1fr; /* Fleksibel jika dibuka di layar HP */
            }
        }

        /* KARTU PANEL */
        .panel-card {
            background: var(--bg-white);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(139, 95, 191, 0.08);
            height: fit-content;
        }

        .panel-card h3 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 18px;
            color: var(--taro-accent);
            border-bottom: 2px solid var(--taro-light);
            padding-bottom: 10px;
        }

        /* KOMPONEN FORM */
        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
            color: var(--text-dark);
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 11px 14px;
            background: #FFFFFF;
            border: 2px solid #E2E8F0;
            border-radius: 8px;
            color: var(--text-dark);
            font-size: 14px;
            box-sizing: border-box;
            transition: 0.3s;
            font-family: inherit;
        }

        input[type="text"]:focus, textarea:focus {
            outline: none;
            border-color: var(--taro-primary);
            box-shadow: 0 0 0 3px rgba(139, 95, 191, 0.2);
        }

        textarea {
            resize: vertical;
        }

        input[type="file"] {
            width: 100%;
            padding: 10px;
            background: var(--taro-light);
            border: 2px dashed var(--taro-primary);
            border-radius: 8px;
            color: var(--text-dark);
            box-sizing: border-box;
            cursor: pointer;
        }

        .btn-submit {
            background-color: var(--taro-primary);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 15px;
            cursor: pointer;
            transition: 0.3s;
            display: inline-block;
        }

        .btn-submit:hover {
            background-color: var(--taro-accent);
        }

        .btn-cancel {
            background-color: #E2E8F0;
            color: var(--text-dark);
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 15px;
            display: inline-block;
            transition: 0.3s;
            text-align: center;
        }

        .btn-cancel:hover {
            background-color: #CBD5E1;
        }

        /* NOTIFIKASI ALERTS */
        .alert {
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 14px;
            font-weight: 600;
        }

        .alert-success {
            background-color: #D1FAE5;
            color: #065F46;
            border: 1px solid #A7F3D0;
        }

        .alert-danger {
            background: #FEE2E2;
            border: 1px solid #FCA5A5;
            color: #991B1B;
        }

        /* TABEL DATA SEBELAH KANAN */
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background-color: var(--taro-light);
            color: var(--taro-accent);
            padding: 12px 15px;
            font-weight: 600;
            font-size: 14px;
            border-bottom: 2px solid #CBD5E1;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #E2E8F0;
            font-size: 14px;
            vertical-align: middle;
        }

        tr:hover {
            background-color: #FAFAFA;
        }

        .cover-preview {
            width: 45px;
            height: 45px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid #E2E8F0;
            margin-right: 10px;
        }

        /* BUTTON AKSI EDIT DAN HAPUS */
        .action-flex {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            padding: 6px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            border: none;
            transition: 0.2s;
            display: inline-block;
        }

        .btn-edit {
            background-color: rgba(255, 168, 0, 0.1);
            color: #B25E00;
        }

        .btn-edit:hover {
            background-color: var(--warning);
            color: black;
        }

        .btn-delete {
            background-color: rgba(230, 57, 70, 0.1);
            color: var(--danger);
        }

        .btn-delete:hover {
            background-color: var(--danger);
            color: white;
        }
    </style>
</head>
<body>

<div class="container">

    <header>
        <div>
            <h2>Dashboard Admin</h2>
            <p style="margin:0; color: var(--text-muted); font-size:12px;">Kelola Hub Musik Kamu</p>
        </div>
        <a href="/music" class="btn-back">← Ke Web Musik</a>
    </header>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Aduh, ada yang salah:</strong>
            <ul style="margin: 5px 0 0 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="admin-layout">
        
        <div class="panel-card">
            <h3>{{ isset($track) ? 'Edit Lagu' : 'Tambah Lagu Baru' }}</h3>
            
            <form action="{{ isset($track) ? route('admin.update', $track->id) : route('admin.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($track)) @method('PUT') @endif

                <div class="form-group">
                    <label>Judul Lagu</label>
                    <input type="text" name="title" value="{{ $track->title ?? '' }}" required placeholder="Contoh: Ghost">
                </div>
                
                <div class="form-group">
                    <label>Artis / Penyanyi</label>
                    <input type="text" name="artist" value="{{ $track->artist ?? '' }}" required placeholder="Contoh: Justin Bieber">
                </div>
                
                <div class="form-group">
                    <label>Pilih File Audio (.mp3)</label>
                    <input type="file" name="audio_file" accept="audio/mp3, audio/mpeg" {{ isset($track) ? '' : 'required' }}>
                    @if(isset($track) && $track->audio_url)
                        <small style="color: var(--taro-primary); display:block; margin-top:5px;">File audio saat ini sudah aman tersimpan.</small>
                    @endif
                </div>
                
                <div class="form-group">
                    <label>Pilih Gambar Cover (.jpg / .png) - Opsional</label>
                    <input type="file" name="cover_file" accept="image/*">
                    @if(isset($track) && $track->cover_url)
                        <small style="color: var(--taro-primary); display:block; margin-top:5px;">Gambar cover lama sudah ada di sistem.</small>
                    @endif
                </div>

                <div class="form-group">
                    <label>Lirik Lagu</label>
                    <textarea name="lyrics" rows="6" placeholder="Ketik atau tempel lirik lagu di sini...">{{ $track->lyrics ?? '' }}</textarea>
                </div>

                <div class="form-group">
              <label>Pilih File Lirik (.lrc) - Opsional</label>
                <input type="file" name="lrc_file" accept=".lrc">
           @if(isset($track) && $track->lrc_file)
                 <small style="color: var(--taro-primary); display:block; margin-top:5px;">File lirik (.lrc) sudah aman tersimpan.</small>
            @endif
                </div>

                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" class="btn-submit" style="flex: 2;">
                        {{ isset($track) ? 'Perbarui Musik ✨' : 'Simpan Musik 🚀' }}
                    </button>
                    @if(isset($track))
                        <a href="{{ route('admin.index') }}" class="btn-cancel" style="flex: 1;">Batal</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="panel-card">
            <h3>Daftar Musik Terupload</h3>
            
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Cover</th>
                            <th>Judul & Artis</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tracks as $t)
                        <tr>
                            <td>
                                <img class="cover-preview" src="{{ $t->cover_url ? asset($t->cover_url) : 'https://via.placeholder.com/150' }}" alt="cover">
                            </td>
                            
                            <td>
                                <strong style="color: var(--text-dark); font-size: 15px;">{{ $t->title }}</strong><br>
                                <span style="color: var(--text-muted); font-size: 13px;">{{ $t->artist }}</span>
                            </td>
                            
                            <td style="text-align: center;">
                                <div class="action-flex" style="justify-content: center;">
                                    <a href="{{ route('admin.edit', $t->id) }}" class="btn-action btn-edit">Edit</a>
                                    
                                    <form action="{{ route('admin.delete', $t->id) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin hapus lagu ini?')" class="btn-action btn-delete">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="text-align:center; color: var(--text-muted); padding: 30px;">
                                Belum ada lagu yang diinput. Yuk tambahkan koleksi pertamamu di sebelah kiri!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

</body>
</html>