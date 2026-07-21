<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-hub: Music Player Pro Space Purple Edition</title>
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            /* Palette warna Space Cyberpunk Purple */
            --bg-card: rgba(15, 12, 28, 0.75);     /* Ungu gelap transparan transparan */
            --neon-pink: #ff2d55;                  /* Pink menyala */
            --neon-orange: #ff9500;                /* Oranye highlight */
            --neon-cyan: #4cd964;                  /* Hijau toska favorit */
            --duet-purple: #8B5FBF;                /* Ungu luar angkasa */
            --space-purple: #a170e6;               /* Ungu terang bercahaya */
            --text-light: #ffffff;                 /* Teks putih terang */
            --text-muted: #abb2bf;                 /* Teks abu-abu redup */
            --sidebar-space: #141122;              /* Ungu sangat gelap untuk sidebar */
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            /* Menggunakan gambar luar angkasa ungu yang kamu kirim */
            background-image: url('https://w0.peakpx.com/wallpaper/225/306/HD-wallpaper-space-stars-nebula-night-purple-sky.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: var(--text-light);
            margin: 0;
            padding: 20px;
            overflow-x: hidden;
        }

        #main-app { max-width: 1350px; margin: 0 auto; position: relative; z-index: 1; }

        /* NAVIGASI ATAS */
        #main-nav {
            display: flex; justify-content: space-between;
            background: var(--bg-card); padding: 15px 25px;
            border-radius: 12px; box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
            margin-bottom: 25px;
            border: 1px solid rgba(139, 95, 191, 0.25);
            backdrop-filter: blur(10px);
        }
        .nav-btn {
            background: none; border: none; padding: 8px 16px;
            font-weight: bold; cursor: pointer; color: var(--text-muted);
            border-radius: 6px; transition: 0.3s;
        }
        .nav-btn.active, .nav-btn:hover { background-color: rgba(139, 95, 191, 0.2); color: var(--space-purple); }

        /* LAYOUT UTAMA */
        .player-layout {
            display: grid;
            grid-template-columns: 80px 1.2fr 1fr;
            gap: 20px;
        }

        /* SIDEBAR NAV */
        .sidebar-nav {
            background-color: var(--sidebar-space);
            border-radius: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 0;
            gap: 20px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.6);
            border: 1px solid rgba(139, 95, 191, 0.2);
        }

        .side-btn {
            width: 50px; height: 50px;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; color: white;
            transition: 0.3s;
        }
        .btn-fav { background-color: var(--neon-cyan); box-shadow: 0 0 10px rgba(76, 217, 100, 0.4); }
        .btn-duet { background-color: var(--duet-purple); box-shadow: 0 0 10px rgba(139, 95, 191, 0.4); }
        .side-btn:hover { transform: scale(1.1); filter: brightness(1.2); }

        /* PLAYER CARD */
        #player-card {
            background: var(--bg-card); border-radius: 16px; padding: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.6); text-align: center;
            border: 1px solid rgba(139, 95, 191, 0.25);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }
        
        /* CANVAS JAVASCRIPT UNTUK EFEK BINTANG */
        #star-canvas {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        /* VINYL CONTAINER */
        .vinyl-container {
            width: 220px; height: 220px; margin: 0 auto 20px;
            border-radius: 50%; overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.8); background: #000;
            display: flex; align-items: center; justify-content: center;
            border: 3px solid var(--space-purple);
            position: relative; z-index: 1;
        }
        #current-cover { width: 100%; height: 100%; object-fit: cover; }
        .spinning { animation: spin 12s linear infinite; }
        @keyframes spin { 100% { transform: rotate(360deg); } }

        .timeline-container { display: flex; align-items: center; gap: 10px; margin: 20px 0; position: relative; z-index: 1; }
        .seek-slider { flex: 1; accent-color: var(--space-purple); background: #242834; height: 6px; border-radius: 3px; }

        /* PLAYLIST */
        .playlist-container {
            background: var(--bg-card); border-radius: 16px; padding: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.6); max-height: 650px; overflow-y: auto;
            border: 1px solid rgba(139, 95, 191, 0.25);
            backdrop-filter: blur(10px);
        }
        .search-box { 
            width: 100%; padding: 12px; background: rgba(10, 11, 15, 0.6); 
            border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; 
            margin-bottom: 15px; outline: none; color: white; box-sizing: border-box;
        }
        .search-box:focus { border-color: var(--space-purple); }
        .playlist { list-style: none; padding: 0; margin: 0; }
        
        .playlist-item {
            display: flex; justify-content: space-between; align-items: center;
            padding: 12px 15px; border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            cursor: pointer; border-radius: 8px; transition: 0.2s;
        }
        .playlist-item:hover { background-color: rgba(255, 255, 255, 0.05); }
        
        .fav-heart { color: #333945; transition: 0.3s; font-size: 18px; margin-right: 10px; }
        .fav-heart.active { color: var(--neon-cyan); text-shadow: 0 0 8px var(--neon-cyan); }
        .play-icon { color: var(--space-purple); font-weight: bold; }

        /* PANEL LIRIK LAGU (DIPERBAIKI) */
        .lyrics-panel {
            margin-top: 25px; padding: 20px; background-color: rgba(10, 8, 20, 0.6);
            border-radius: 12px; text-align: left; height: 220px; overflow-y: auto; 
            border: 1px solid rgba(139, 95, 191, 0.2); scroll-behavior: smooth;
            position: relative; z-index: 2; /* Naikkan z-index agar bisa di-scroll manual dengan aman */
        }
        .lyrics-title {
            font-weight: bold; color: var(--neon-orange); margin-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1); padding-bottom: 5px;
            font-size: 14px; text-transform: uppercase; letter-spacing: 1px;
        }
        #lyrics-content { font-size: 16px; line-height: 2; color: var(--text-muted); padding-bottom: 100px; }
        
        .lrc-line { 
            opacity: 0.25; 
            margin: 12px 0; 
            transition: all 0.3s ease; 
            font-weight: 500; 
            color: var(--text-light);
        }
        .lrc-line.active { 
            opacity: 1; 
            color: var(--space-purple); 
            font-weight: 700; 
            font-size: 18px; 
            text-shadow: 0 0 12px rgba(161, 112, 230, 0.6); 
        }

        /* FULLSCREEN OVERLAY KARAOKE */
        #duet-overlay {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: #09070f; z-index: 9999; color: white;
            flex-direction: column; align-items: center; justify-content: center; text-align: center;
        }
        #duet-lyrics { 
            font-size: 2.5em; font-weight: bold; color: #444;
            margin: 40px; min-height: 120px; max-width: 80%; transition: 0.3s;
        }
        .duet-active-lyric { color: var(--space-purple) !important; text-shadow: 0 0 15px rgba(161, 112, 230, 0.8); }

        /* MODAL PENILAIAN */
        #score-modal {
            display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
            background: rgba(15, 12, 28, 0.95); color: var(--text-light); padding: 40px;
            border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.8);
            text-align: center; z-index: 10000; width: 350px;
            border: 1px solid var(--space-purple);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>

<div id="duet-overlay">
    <div style="position: absolute; top: 20px; left: 30px; text-align: left;">
        <h2 style="color: var(--space-purple); margin: 0; letter-spacing: 1px;">🎤 MODE KARAOKE</h2>
        <small id="duet-status" style="color: var(--neon-cyan);">🎙️ Mikrofon Aktif...</small>
    </div>
    <div id="duet-lyrics">Pilih lagu lalu masuk mode ini untuk bernyanyi!</div>
    <button onclick="closeDuet()" style="padding: 12px 40px; font-weight: bold; border-radius: 50px; border: none; background: #e74c3c; color: white; cursor: pointer; font-size: 16px;">
        🛑 Berhenti & Beri Nilai
    </button>
</div>

<div id="score-modal">
    <h2 style="margin-top: 0; color: var(--neon-orange);">Hasil Bernyanyi Kamu 🏆</h2>
    <div style="font-size: 4em; font-weight: bold; color: var(--space-purple); margin: 20px 0; text-shadow: 0 0 10px rgba(161, 112, 230, 0.6);" id="final-score">0</div>
    <h3 id="score-predicate" style="color: var(--neon-cyan);">Bagus Banget!</h3>
    <button onclick="closeScoreModal()" style="padding: 10px 25px; background: var(--space-purple); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; margin-top: 15px;">Selesai</button>
</div>

<div id="main-app">
    <nav id="main-nav">
        <div>
            <button class="nav-btn active">Musik</button>
            <button class="nav-btn" onclick="alert('Fitur game segera hadir!')">Game</button> 
            <button class="nav-btn" onclick="alert('Fitur nonton segera hadir!')">Nonton</button> 
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-btn" style="color: #E63946;">Logout</button>
        </form>
    </nav>
    
    <div class="player-layout">
        <div class="sidebar-nav">
            <button class="side-btn btn-fav" onclick="showFavorites()" title="Musik Favorit">
                <i class="fa-solid fa-heart"></i>
            </button>
            <button class="side-btn btn-duet" onclick="openDuet()" title="Mode Duet / Karaoke">
                <i class="fa-solid fa-microphone"></i>
            </button>
        </div>

        <div id="player-card">
            <canvas id="star-canvas"></canvas>

            <div class="vinyl-container">
                <img id="current-cover" src="https://via.placeholder.com/150" alt="cover">
            </div>
            <h3 id="current-title" style="margin: 10px 0 5px 0; position: relative; z-index: 1;">Pilih lagu di samping</h3>
            <p id="current-artist" style="color: var(--text-muted); margin: 0 0 20px 0; position: relative; z-index: 1;">-</p>

            <div class="timeline-container">
                <span id="current-time" style="color: var(--text-muted); font-size: 14px;">0:00</span>
                <input type="range" id="seek-slider" class="seek-slider" min="0" value="0" max="100">
                <span id="total-duration" style="color: var(--text-muted); font-size: 14px;">0:00</span>
            </div>

            <audio id="audio-element"></audio>

            <div class="controls" style="display: flex; align-items: center; justify-content: center; gap: 20px; margin-top: 10px; position: relative; z-index: 1;">
                <button id="repeat-btn" style="background: none; color: var(--text-muted); font-size: 20px; border: none; cursor: pointer;">🔁</button>
                <button id="prev-btn" style="background: none; color: var(--text-light); font-size: 24px; border: none; cursor: pointer;">⏮</button>
                <button id="play-btn" style="background-color: var(--space-purple); color: white; border: none; padding: 12px 35px; border-radius: 50px; font-size: 16px; font-weight: bold; cursor: pointer; box-shadow: 0 4px 15px rgba(161, 112, 230, 0.4);">▶ Play</button>
                <button id="next-btn" style="background: none; color: var(--text-light); font-size: 24px; border: none; cursor: pointer;">⏭</button>
            </div>

            <div class="lyrics-panel" id="lyrics-panel">
                <div class="lyrics-title">Lirik Lagu</div>
                <div id="lyrics-content">Belum ada lagu diputar.</div>
            </div>
        </div>

        <div class="playlist-container">
            <h3 id="playlist-title" style="margin-top: 0;">Daftar Semua Lagu</h3>
            <input type="text" id="search-input" class="search-box" placeholder="🔍 Cari lagu atau artis...">
            
            <ul class="playlist" id="playlist-list">
                @forelse($tracks as $track)
                    <li class="playlist-item" 
                        data-id="{{ $track->id }}"
                        data-title="{{ strtolower($track->title) }}" 
                        data-artist="{{ strtolower($track->artist) }}"
                        onclick="playMusic('{{ asset($track->audio_url) }}', '{{ $track->title }}', '{{ $track->artist }}', '{{ $track->cover_url ? asset($track->cover_url) : 'https://via.placeholder.com/150' }}', '{{ addslashes($track->lyrics ?? 'Lirik tidak tersedia.') }}', '{{ $track->lrc_file ? asset($track->lrc_file) : '' }}', {{ $loop->index }})">
                        
                        <div>
                            <strong>{{ $track->title }}</strong> <br>
                            <small style="color: var(--text-muted);">{{ $track->artist }}</small>
                        </div>
                        
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <i class="fa-solid fa-heart fav-heart" onclick="event.stopPropagation(); toggleFavorite(event, {{ $track->id }})"></i>
                            <span class="play-icon">▶</span>
                        </div>
                    </li>
                @empty
                    <p style="text-align: center; color: var(--text-muted);">Tidak ada lagu.</p>
                @endforelse
            </ul>
        </div>
    </div>
</div>

<script>
    const audio = document.getElementById('audio-element');
    const playBtn = document.getElementById('play-btn');
    const lyricsContent = document.getElementById('lyrics-content');
    const lyricsPanel = document.getElementById('lyrics-panel');
    const duetOverlay = document.getElementById('duet-overlay');
    const duetLyrics = document.getElementById('duet-lyrics');
    const seekSlider = document.getElementById('seek-slider');
    const currentTimeText = document.getElementById('current-time');
    const totalDurationText = document.getElementById('total-duration');
    const searchInput = document.getElementById('search-input');
    const currentCover = document.getElementById('current-cover');
    
    let currentTrackIndex = -1;
    let isRepeatActive = false;
    let parsedLyrics = [];
    let isScrubbing = false;
    let favoriteIds = JSON.parse(localStorage.getItem('favTracks')) || [];
    let lastActiveIndex = -1; // Mencegah pemanggilan scroll berulang-ulang

    // Variabel rekaman
    let audioContext = null;
    let micStream = null;
    let micSource = null;
    let audioProcessor = null;
    let totalSingingVolume = 0;
    let volumeCheckCount = 0;

    // SISTEM PARTIKEL CANVAS BINTANG
    const canvas = document.getElementById('star-canvas');
    const ctx = canvas.getContext('2d');
    let stars = [];
    let starInterval = null;

    function resizeCanvas() {
        const playerCard = document.getElementById('player-card');
        canvas.width = playerCard.clientWidth;
        canvas.height = playerCard.clientHeight;
    }
    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);

    class Star {
        constructor(x, y, radius, color, velocity) {
            this.x = x;
            this.y = y;
            this.radius = radius;
            this.color = color;
            this.velocity = velocity;
            this.opacity = 1;
            this.life = Math.random() * 80 + 60;
        }
        draw() {
            ctx.save();
            ctx.globalAlpha = this.opacity;
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2, false);
            ctx.fillStyle = this.color;
            ctx.fill();
            ctx.restore();
        }
        update() {
            this.x += this.velocity.x;
            this.y += this.velocity.y;
            this.radius -= 0.008;
            this.opacity -= 0.008;
            if (this.radius < 0) this.radius = 0;
            if (this.opacity < 0) this.opacity = 0;
            this.draw();
        }
    }

    function spawnStar() {
        const vinylContainer = document.querySelector('.vinyl-container');
        const vinylX = canvas.width / 2;
        const vinylY = vinylContainer.offsetTop + (vinylContainer.clientHeight / 2);
        
        const radius = Math.random() * 2 + 0.6;
        // Gradasi warna ungu angkasa berkilau
        const color = `hsla(${Math.random() * 40 + 260}, 85%, 75%, 1)`;
        const velocity = {
            x: (Math.random() - 0.5) * (Math.random() * 3 + 2), 
            y: (Math.random() - 0.5) * (Math.random() * 3 + 2) 
        };
        stars.push(new Star(vinylX, vinylY, radius, color, velocity));
    }

    function animateStars() {
        requestAnimationFrame(animateStars);
        ctx.clearRect(0, 0, canvas.width, canvas.height); // Gunakan clearRect agar tumpukan canvas bersih total

        stars.forEach((star, index) => {
            if (star.opacity <= 0 || star.radius <= 0) {
                stars.splice(index, 1);
            } else {
                star.update();
            }
        });
    }
    animateStars();

    // FAVORIT & SEARCHING
    document.querySelectorAll('.playlist-item').forEach(item => {
        const id = parseInt(item.getAttribute('data-id'));
        if (favoriteIds.includes(id)) {
            item.querySelector('.fav-heart').classList.add('active');
        }
    });

    searchInput.addEventListener('input', function() {
        const keyword = this.value.toLowerCase().trim();
        document.querySelectorAll('.playlist-item').forEach(item => {
            const title = item.getAttribute('data-title');
            const artist = item.getAttribute('data-artist');
            if (title.includes(keyword) || artist.includes(keyword)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });

    function toggleFavorite(event, trackId) {
        event.stopPropagation();
        const icon = event.target;
        if (favoriteIds.includes(trackId)) {
            favoriteIds = favoriteIds.filter(id => id !== trackId);
            icon.classList.remove('active');
        } else {
            favoriteIds.push(trackId);
            icon.classList.add('active');
        }
        localStorage.setItem('favTracks', JSON.stringify(favoriteIds));
    }

    function showFavorites() {
        const title = document.getElementById('playlist-title');
        const items = document.querySelectorAll('.playlist-item');
        if (title.innerText === "Daftar Semua Lagu") {
            title.innerText = "❤️ Musik Favorit Kamu";
            title.style.color = "var(--neon-cyan)";
            items.forEach(item => {
                const id = parseInt(item.getAttribute('data-id'));
                item.style.display = favoriteIds.includes(id) ? 'flex' : 'none';
            });
        } else {
            title.innerText = "Daftar Semua Lagu";
            title.style.color = "var(--text-light)";
            items.forEach(item => item.style.display = 'flex');
        }
    }

    // MODE DUET / KARAOKE
    function openDuet() {
        if (currentTrackIndex === -1) return alert("Silakan pilih dan putar lagu terlebih dahulu!");
        duetOverlay.style.display = 'flex';
        totalSingingVolume = 0;
        volumeCheckCount = 0;

        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ audio: true })
            .then(function(stream) {
                micStream = stream;
                audioContext = new (window.AudioContext || window.webkitAudioContext)();
                micSource = audioContext.createMediaStreamSource(stream);
                audioProcessor = audioContext.createScriptProcessor(2048, 1, 1);
                audioProcessor.onaudioprocess = function(e) {
                    const inputBuffer = e.inputBuffer.getChannelData(0);
                    let sum = 0;
                    for (let i = 0; i < inputBuffer.length; i++) { sum += inputBuffer[i] * inputBuffer[i]; }
                    const rms = Math.sqrt(sum / inputBuffer.length);
                    totalSingingVolume += rms;
                    volumeCheckCount++;
                };
                micSource.connect(audioContext.destination);
                micSource.connect(audioProcessor);
                audioProcessor.connect(audioContext.destination);
            })
            .catch(function(err) {
                console.log(err);
            });
        }
    }

    function closeDuet() {
        duetOverlay.style.display = 'none';
        audio.pause();
        playBtn.textContent = '▶ Play';
        currentCover.classList.remove('spinning');
        clearInterval(starInterval);

        if (micStream) micStream.getTracks().forEach(track => track.stop());
        if (audioContext) audioContext.close();

        let averageVolume = volumeCheckCount > 0 ? (totalSingingVolume / volumeCheckCount) * 100 : 0;
        let score = Math.min(Math.floor(averageVolume * 15), 100); 
        if (score < 30) score = Math.floor(Math.random() * 20 + 35);

        document.getElementById('final-score').innerText = score;
        document.getElementById('score-modal').style.display = 'block';
    }

    function closeScoreModal() { document.getElementById('score-modal').style.display = 'none'; }

    // KONTROL UTAMA MUSIK & LIRIK
    function playMusic(url, title, artist, cover, lyrics, lrcUrl, index) {
        currentTrackIndex = index;
        document.getElementById('current-title').textContent = "Memuat lagu...";
        document.getElementById('current-artist').textContent = "Mohon tunggu...";
        lyricsContent.innerHTML = "Memuat lirik..."; 
        currentCover.classList.remove('spinning');
        clearInterval(starInterval);
        stars = [];
        lastActiveIndex = -1;

        seekSlider.value = 0;
        currentTimeText.textContent = "0:00";
        totalDurationText.textContent = "0:00";
        parsedLyrics = [];
        duetLyrics.innerText = "Bersiaplah...";

        fetch(url)
            .then(response => {
                if (!response.ok) throw new Error("Gagal mengambil audio");
                return response.blob();
            })
            .then(blob => {
                const blobUrl = URL.createObjectURL(blob);
                audio.src = blobUrl;
                initTrackMetaData(title, artist, cover, lyrics, lrcUrl);
            })
            .catch(error => {
                audio.src = url;
                initTrackMetaData(title, artist, cover, lyrics, lrcUrl);
            });
    }

    function initTrackMetaData(title, artist, cover, lyrics, lrcUrl) {
        document.getElementById('current-title').textContent = title;
        document.getElementById('current-artist').textContent = artist;
        currentCover.src = cover;

        if (lrcUrl) {
            fetch(lrcUrl)
                .then(res => res.text())
                .then(lrcText => {
                    parsedLyrics = parseLRC(lrcText);
                    displaySyncLyrics();
                });
        } else {
            lyricsContent.innerHTML = lyrics.replace(/\n/g, '<br>');
            duetLyrics.innerText = "Lirik sinkronisasi tidak tersedia.";
        }

        audio.play().then(() => {
            currentCover.classList.add('spinning');
            clearInterval(starInterval);
            starInterval = setInterval(spawnStar, 80); 
        }).catch(() => {});
        playBtn.textContent = '⏸ Pause';
    }

    function parseLRC(lrcText) {
        const lines = lrcText.split('\n');
        const lrcArray = [];
        const timeReg = /\[(\d{2}):(\d{2})\.(\d{2,3})\]/;

        lines.forEach(line => {
            const matches = timeReg.exec(line);
            if (matches) {
                const minutes = parseInt(matches[1]);
                const seconds = parseInt(matches[2]);
                const milliseconds = parseInt(matches[3]);
                const timeInSeconds = minutes * 60 + seconds + (milliseconds / (milliseconds > 99 ? 1000 : 100));
                const text = line.replace(timeReg, '').trim();
                if (text) lrcArray.push({ time: timeInSeconds, text: text });
            }
        });
        return lrcArray.sort((a, b) => a.time - b.time);
    }

    function displaySyncLyrics() {
        lyricsContent.innerHTML = '';
        parsedLyrics.forEach((item, index) => {
            const lineElement = document.createElement('div');
            lineElement.classList.add('lrc-line');
            lineElement.setAttribute('id', `lrc-${index}`);
            lineElement.textContent = item.text;
            lyricsContent.appendChild(lineElement);
        });
    }

    // MEMPERBAIKI KASUS LIRIK KUNCI & MACET SAAT TIMEUPDATE
    audio.addEventListener('timeupdate', () => {
        if (!isScrubbing) {
            seekSlider.value = Math.floor(audio.currentTime);
            currentTimeText.textContent = formatTime(audio.currentTime);
        }

        if (parsedLyrics.length > 0) {
            const currentTime = audio.currentTime;
            let activeIndex = -1;

            for (let i = 0; i < parsedLyrics.length; i++) {
                if (currentTime >= parsedLyrics[i].time) {
                    activeIndex = i;
                } else {
                    break;
                }
            }

            // Hanya lakukan perubahan scroll jika baris liriknya benar-benar berganti
            if (activeIndex !== -1 && activeIndex !== lastActiveIndex) {
                lastActiveIndex = activeIndex;

                document.querySelectorAll('.lrc-line').forEach(el => el.classList.remove('active'));
                const activeLine = document.getElementById(`lrc-${activeIndex}`);
                
                if (activeLine) {
                    activeLine.classList.add('active');
                    duetLyrics.innerHTML = `<span class="duet-active-lyric">${activeLine.innerText}</span>`;
                    
                    // PERBAIKAN SCROLL JAVASCRIPT: Menggunakan cara hitung yang independen
                    const panelTop = lyricsPanel.getBoundingClientRect().top;
                    const lineTop = activeLine.getBoundingClientRect().top;
                    const relativeTop = lineTop - panelTop;

                    // Lakukan scroll otomatis tepat di tengah container panel lirik
                    lyricsPanel.scrollTop += relativeTop - (lyricsPanel.clientHeight / 2) + (activeLine.clientHeight / 2);
                }
            }
        }
    });

    audio.addEventListener('loadedmetadata', () => {
        seekSlider.max = Math.floor(audio.duration);
        totalDurationText.textContent = formatTime(audio.duration);
    });

    function formatTime(seconds) {
        if (isNaN(seconds)) return "0:00";
        const mins = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
    }

    playBtn.onclick = () => {
        if (audio.src === "" || audio.getAttribute('src') === null) return;
        if (audio.paused) {
            audio.play();
            playBtn.textContent = '⏸ Pause';
            currentCover.classList.add('spinning');
            clearInterval(starInterval); 
            starInterval = setInterval(spawnStar, 80); 
        } else {
            audio.pause();
            playBtn.textContent = '▶ Play';
            currentCover.classList.remove('spinning');
            clearInterval(starInterval);
        }
    };

    function switchTrack(direction) {
        const items = document.querySelectorAll('.playlist-item');
        if (items.length === 0 || currentTrackIndex === -1) return;
        let newIndex = (currentTrackIndex + direction + items.length) % items.length;
        items[newIndex].click();
    }

    document.getElementById('next-btn').onclick = () => switchTrack(1);
    document.getElementById('prev-btn').onclick = () => switchTrack(-1);

    const repeatBtn = document.getElementById('repeat-btn');
    repeatBtn.onclick = () => {
        isRepeatActive = !isRepeatActive;
        repeatBtn.style.color = isRepeatActive ? "var(--space-purple)" : "var(--text-muted)";
    };

    audio.addEventListener('ended', () => {
        if (duetOverlay.style.display === 'flex') {
            closeDuet();
        } else {
            if (isRepeatActive) { audio.currentTime = 0; audio.play(); }
            else { switchTrack(1); }
        }
    });

    seekSlider.addEventListener('mousedown', () => { isScrubbing = true; });
    seekSlider.addEventListener('touchstart', () => { isScrubbing = true; });
    seekSlider.addEventListener('input', () => { currentTimeText.textContent = formatTime(seekSlider.value); });
    seekSlider.addEventListener('change', () => {
        if (!isNaN(audio.duration)) { audio.currentTime = seekSlider.value; }
        isScrubbing = false;
    });
</script>
</body>
</html>