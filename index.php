<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Blog (CMS)</title>
    <style>
        /* ── Reset & Base ─────────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            color: #333;
            min-height: 100vh;
        }

        /* ── Header ───────────────────────────────────────────────────── */
        header {
            background: linear-gradient(135deg, #1a73e8, #0d47a1);
            color: #fff;
            padding: 0 28px;
            height: 60px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,.25);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        header h1 { font-size: 1.25rem; font-weight: 600; letter-spacing: .3px; }

        /* ── Layout ───────────────────────────────────────────────────── */
        .wrapper { display: flex; min-height: calc(100vh - 60px); }

        /* ── Sidebar / Nav ────────────────────────────────────────────── */
        nav.sidebar {
            width: 220px;
            background: #fff;
            border-right: 1px solid #e0e0e0;
            padding: 20px 0;
            flex-shrink: 0;
        }
        nav.sidebar p.label {
            font-size: .7rem;
            font-weight: 700;
            color: #9e9e9e;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 0 20px 10px;
        }
        nav.sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            color: #555;
            text-decoration: none;
            font-size: .9rem;
            font-weight: 500;
            border-left: 3px solid transparent;
            transition: all .2s;
        }
        nav.sidebar a:hover { background: #e8f0fe; color: #1a73e8; }
        nav.sidebar a.aktif {
            background: #e8f0fe;
            color: #1a73e8;
            border-left-color: #1a73e8;
            font-weight: 600;
        }
        nav.sidebar a .icon { font-size: 1.1rem; }

        /* ── Main Content ─────────────────────────────────────────────── */
        main#konten {
            flex: 1;
            padding: 28px;
            overflow-x: auto;
        }

        /* ── Section Header ───────────────────────────────────────────── */
        .seksi-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .seksi-header h2 { font-size: 1.3rem; color: #1a237e; }

        /* ── Buttons ──────────────────────────────────────────────────── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: .85rem;
            font-weight: 600;
            transition: all .2s;
        }
        .btn-primary  { background: #1a73e8; color: #fff; }
        .btn-primary:hover  { background: #1558b0; }
        .btn-warning  { background: #f9a825; color: #fff; }
        .btn-warning:hover  { background: #e65100; }
        .btn-danger   { background: #e53935; color: #fff; }
        .btn-danger:hover   { background: #b71c1c; }
        .btn-secondary{ background: #757575; color: #fff; }
        .btn-secondary:hover{ background: #424242; }
        .btn-sm { padding: 5px 10px; font-size: .78rem; }

        /* ── Table ────────────────────────────────────────────────────── */
        .card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
            overflow: hidden;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: .88rem;
        }
        thead tr { background: #1a73e8; color: #fff; }
        thead th { padding: 12px 14px; text-align: left; font-weight: 600; }
        tbody tr { border-bottom: 1px solid #f0f0f0; transition: background .15s; }
        tbody tr:hover { background: #f9f9ff; }
        tbody td { padding: 10px 14px; vertical-align: middle; }
        .foto-thumb {
            width: 44px; height: 44px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #e0e0e0;
        }
        .gambar-thumb {
            width: 70px; height: 48px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
        }
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: .75rem;
            font-weight: 600;
            background: #e8f0fe;
            color: #1a73e8;
        }
        .aksi { display: flex; gap: 6px; flex-wrap: nowrap; }

        /* ── Empty / Loading State ────────────────────────────────────── */
        .state-info {
            text-align: center;
            padding: 48px 24px;
            color: #9e9e9e;
            font-size: .95rem;
        }

        /* ── Toast Notification ───────────────────────────────────────── */
        #toast {
            position: fixed;
            bottom: 28px; right: 28px;
            padding: 12px 20px;
            border-radius: 8px;
            color: #fff;
            font-size: .88rem;
            font-weight: 600;
            box-shadow: 0 4px 16px rgba(0,0,0,.2);
            opacity: 0;
            transform: translateY(10px);
            transition: all .3s;
            z-index: 9999;
            pointer-events: none;
            max-width: 340px;
        }
        #toast.tampil { opacity: 1; transform: translateY(0); }
        #toast.sukses { background: #2e7d32; }
        #toast.gagal  { background: #c62828; }

        /* ── Modal Overlay ────────────────────────────────────────────── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.45);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .modal-overlay.tampil { display: flex; }
        .modal {
            background: #fff;
            border-radius: 12px;
            width: 100%;
            max-width: 520px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 8px 32px rgba(0,0,0,.25);
            animation: slideUp .25s ease;
        }
        .modal.modal-sm { max-width: 380px; }
        @keyframes slideUp {
            from { transform: translateY(30px); opacity: 0; }
            to   { transform: translateY(0);    opacity: 1; }
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 22px;
            border-bottom: 1px solid #eee;
        }
        .modal-header h3 { font-size: 1.05rem; color: #1a237e; }
        .modal-header .close-btn {
            background: none; border: none;
            font-size: 1.4rem; cursor: pointer;
            color: #757575; line-height: 1;
        }
        .modal-header .close-btn:hover { color: #333; }
        .modal-body    { padding: 22px; }
        .modal-footer  {
            padding: 14px 22px;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* ── Form ─────────────────────────────────────────────────────── */
        .form-group { margin-bottom: 16px; }
        .form-group label {
            display: block;
            font-size: .82rem;
            font-weight: 600;
            color: #555;
            margin-bottom: 6px;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 9px 12px;
            border: 1.5px solid #ccc;
            border-radius: 6px;
            font-size: .88rem;
            font-family: inherit;
            transition: border-color .2s;
            background: #fafafa;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #1a73e8;
            background: #fff;
        }
        .form-group textarea { resize: vertical; min-height: 100px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .preview-foto {
            width: 64px; height: 64px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #e0e0e0;
            margin-top: 8px;
            display: none;
        }
        .preview-gambar {
            width: 100%; max-height: 140px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            margin-top: 8px;
            display: none;
        }
        .hint { font-size: .75rem; color: #9e9e9e; margin-top: 4px; }

        /* ── Konfirmasi Hapus ─────────────────────────────────────────── */
        .konfirmasi-ikon { font-size: 3rem; text-align: center; margin-bottom: 10px; }
        .konfirmasi-teks { text-align: center; color: #555; font-size: .92rem; line-height: 1.6; }
        .konfirmasi-teks strong { color: #c62828; }
    </style>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<!-- ═══════════════════════════════════════════════════════════════════
     HEADER
════════════════════════════════════════════════════════════════════ -->
<header>
    <h1><i class="fa-solid fa-blog"></i> Sistem Manajemen Blog (CMS)</h1>
</header>

<div class="wrapper">

    <!-- ═══════════════════════════════════════════════════════════════
         NAVIGASI KIRI
    ════════════════════════════════════════════════════════════════ -->
    <nav class="sidebar">
        <p class="label">Menu</p>
        <a href="#" id="nav-penulis"   onclick="muatHalaman('penulis');  return false;">
            <span class="icon"><i class="fa-solid fa-users"></i></span> Kelola Penulis
        </a>
        <a href="#" id="nav-artikel"   onclick="muatHalaman('artikel');  return false;">
            <span class="icon"><i class="fa-solid fa-file-lines"></i></span> Kelola Artikel
        </a>
        <a href="#" id="nav-kategori"  onclick="muatHalaman('kategori'); return false;">
            <span class="icon"><i class="fa-solid fa-folder-open"></i></span> Kelola Kategori
        </a>
    </nav>

    <!-- ═══════════════════════════════════════════════════════════════
         KONTEN UTAMA  (diisi dinamis via JavaScript)
    ════════════════════════════════════════════════════════════════ -->
    <main id="konten">
        <div class="state-info">Pilih menu di sebelah kiri untuk memulai.</div>
    </main>
</div>

<!-- ═══════════════════════════════════════════════════════════════════
     TOAST NOTIFICATION
════════════════════════════════════════════════════════════════════ -->
<div id="toast"></div>

<!-- ═══════════════════════════════════════════════════════════════════
     MODAL — PENULIS
════════════════════════════════════════════════════════════════════ -->
<!-- Form Tambah / Edit Penulis -->
<div class="modal-overlay" id="overlay-penulis">
    <div class="modal">
        <div class="modal-header">
            <h3 id="judul-modal-penulis">Tambah Penulis</h3>
            <button class="close-btn" onclick="tutupModal('overlay-penulis')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="form-penulis" enctype="multipart/form-data">
                <input type="hidden" id="penulis-id">
                <div class="form-row">
                    <div class="form-group">
                        <label for="penulis-nama-depan">Nama Depan <span style="color:red">*</span></label>
                        <input type="text" id="penulis-nama-depan" placeholder="Contoh: Budi" required>
                    </div>
                    <div class="form-group">
                        <label for="penulis-nama-belakang">Nama Belakang <span style="color:red">*</span></label>
                        <input type="text" id="penulis-nama-belakang" placeholder="Contoh: Santoso" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="penulis-username">Username <span style="color:red">*</span></label>
                    <input type="text" id="penulis-username" placeholder="Contoh: budisantoso" required>
                </div>
                <div class="form-group">
                    <label for="penulis-password">Password <span style="color:red" id="password-required-mark">*</span></label>
                    <input type="password" id="penulis-password" placeholder="Minimal 6 karakter">
                    <p class="hint" id="password-hint" style="display:none">Kosongkan jika tidak ingin mengubah password.</p>
                </div>
                <div class="form-group">
                    <label for="penulis-foto">Foto Profil</label>
                    <input type="file" id="penulis-foto" accept="image/*" onchange="previewGambar(this,'preview-penulis-foto')">
                    <p class="hint">Format: JPG, PNG, GIF, WEBP. Maks. 2 MB. Biarkan kosong untuk foto default.</p>
                    <img id="preview-penulis-foto" class="preview-foto" alt="Preview Foto">
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="tutupModal('overlay-penulis')">Batal</button>
            <button class="btn btn-primary" onclick="simpanPenulis()"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
        </div>
    </div>
</div>

<!-- Konfirmasi Hapus Penulis -->
<div class="modal-overlay" id="overlay-hapus-penulis">
    <div class="modal modal-sm">
        <div class="modal-header">
            <h3>Konfirmasi Hapus</h3>
            <button class="close-btn" onclick="tutupModal('overlay-hapus-penulis')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="konfirmasi-ikon"><i class="fa-solid fa-trash-can"></i></div>
            <p class="konfirmasi-teks">
                Apakah kamu yakin ingin menghapus penulis<br>
                <strong id="nama-hapus-penulis"></strong>?<br>
                Tindakan ini <strong>tidak dapat dibatalkan</strong>.
            </p>
            <input type="hidden" id="id-hapus-penulis">
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="tutupModal('overlay-hapus-penulis')">Batal</button>
            <button class="btn btn-danger"    onclick="eksekusiHapusPenulis()"><i class="fa-solid fa-trash-can"></i> Ya, Hapus</button>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════════════
     MODAL — KATEGORI
════════════════════════════════════════════════════════════════════ -->
<!-- Form Tambah / Edit Kategori -->
<div class="modal-overlay" id="overlay-kategori">
    <div class="modal modal-sm">
        <div class="modal-header">
            <h3 id="judul-modal-kategori">Tambah Kategori</h3>
            <button class="close-btn" onclick="tutupModal('overlay-kategori')">&times;</button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="kategori-id">
            <div class="form-group">
                <label for="kategori-nama">Nama Kategori <span style="color:red">*</span></label>
                <input type="text" id="kategori-nama" placeholder="Contoh: Teknologi" required>
            </div>
            <div class="form-group">
                <label for="kategori-keterangan">Keterangan</label>
                <textarea id="kategori-keterangan" placeholder="Deskripsi singkat kategori..."></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="tutupModal('overlay-kategori')">Batal</button>
            <button class="btn btn-primary"   onclick="simpanKategori()"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
        </div>
    </div>
</div>

<!-- Konfirmasi Hapus Kategori -->
<div class="modal-overlay" id="overlay-hapus-kategori">
    <div class="modal modal-sm">
        <div class="modal-header">
            <h3>Konfirmasi Hapus</h3>
            <button class="close-btn" onclick="tutupModal('overlay-hapus-kategori')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="konfirmasi-ikon"><i class="fa-solid fa-trash-can"></i></div>
            <p class="konfirmasi-teks">
                Apakah kamu yakin ingin menghapus kategori<br>
                <strong id="nama-hapus-kategori"></strong>?
            </p>
            <input type="hidden" id="id-hapus-kategori">
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="tutupModal('overlay-hapus-kategori')">Batal</button>
            <button class="btn btn-danger"    onclick="eksekusiHapusKategori()"><i class="fa-solid fa-trash-can"></i> Ya, Hapus</button>
        </div>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════════════
     MODAL — ARTIKEL
════════════════════════════════════════════════════════════════════ -->
<!-- Form Tambah / Edit Artikel -->
<div class="modal-overlay" id="overlay-artikel">
    <div class="modal">
        <div class="modal-header">
            <h3 id="judul-modal-artikel">Tambah Artikel</h3>
            <button class="close-btn" onclick="tutupModal('overlay-artikel')">&times;</button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="artikel-id">
            <div class="form-group">
                <label for="artikel-judul">Judul Artikel <span style="color:red">*</span></label>
                <input type="text" id="artikel-judul" placeholder="Judul artikel..." required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="artikel-penulis">Penulis <span style="color:red">*</span></label>
                    <select id="artikel-penulis" required>
                        <option value="">— Pilih Penulis —</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="artikel-kategori">Kategori <span style="color:red">*</span></label>
                    <select id="artikel-kategori" required>
                        <option value="">— Pilih Kategori —</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="artikel-isi">Isi Artikel <span style="color:red">*</span></label>
                <textarea id="artikel-isi" placeholder="Tulis isi artikel di sini..." style="min-height:130px;" required></textarea>
            </div>
            <div class="form-group">
                <label for="artikel-gambar">Gambar Artikel <span style="color:red" id="gambar-required-mark">*</span></label>
                <input type="file" id="artikel-gambar" accept="image/*" onchange="previewGambar(this,'preview-artikel-gambar')">
                <p class="hint">Format: JPG, PNG, GIF, WEBP. Maks. 2 MB.</p>
                <img id="preview-artikel-gambar" class="preview-gambar" alt="Preview Gambar">
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="tutupModal('overlay-artikel')">Batal</button>
            <button class="btn btn-primary"   onclick="simpanArtikel()"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
        </div>
    </div>
</div>

<!-- Konfirmasi Hapus Artikel -->
<div class="modal-overlay" id="overlay-hapus-artikel">
    <div class="modal modal-sm">
        <div class="modal-header">
            <h3>Konfirmasi Hapus</h3>
            <button class="close-btn" onclick="tutupModal('overlay-hapus-artikel')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="konfirmasi-ikon"><i class="fa-solid fa-trash-can"></i></div>
            <p class="konfirmasi-teks">
                Apakah kamu yakin ingin menghapus artikel<br>
                <strong id="judul-hapus-artikel"></strong>?<br>
                File gambar juga akan ikut dihapus dari server.
            </p>
            <input type="hidden" id="id-hapus-artikel">
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="tutupModal('overlay-hapus-artikel')">Batal</button>
            <button class="btn btn-danger"    onclick="eksekusiHapusArtikel()"><i class="fa-solid fa-trash-can"></i> Ya, Hapus</button>
        </div>
    </div>
</div>


<!-- ═══════════════════════════════════════════════════════════════════
     JAVASCRIPT — Fetch API / Async CRUD (tanpa reload halaman)
════════════════════════════════════════════════════════════════════ -->
<script>
'use strict';

/* ══════════════════════════════════════════════════════════════════
   UTILITAS
══════════════════════════════════════════════════════════════════ */

/** Escape HTML untuk keamanan output di JS (setara htmlspecialchars PHP) */
function esc(str) {
    if (str == null) return '';
    return String(str)
        .replace(/&/g,'&amp;')
        .replace(/</g,'&lt;')
        .replace(/>/g,'&gt;')
        .replace(/"/g,'&quot;')
        .replace(/'/g,'&#039;');
}

/** Tampilkan toast notifikasi */
function toast(pesan, tipe = 'sukses') {
    const el = document.getElementById('toast');
    el.textContent = pesan;
    el.className   = `tampil ${tipe}`;
    clearTimeout(el._timer);
    el._timer = setTimeout(() => { el.className = ''; }, 3500);
}

/** Buka modal */
function bukaModal(id) {
    document.getElementById(id).classList.add('tampil');
}

/** Tutup modal */
function tutupModal(id) {
    document.getElementById(id).classList.remove('tampil');
}

/** Tutup modal saat klik overlay */
document.querySelectorAll('.modal-overlay').forEach(el => {
    el.addEventListener('click', e => { if (e.target === el) tutupModal(el.id); });
});

/** Preview gambar sebelum diupload */
function previewGambar(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src   = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
    }
}

/** Set nav aktif */
function setNavAktif(seksi) {
    document.querySelectorAll('nav.sidebar a').forEach(a => a.classList.remove('aktif'));
    const navEl = document.getElementById(`nav-${seksi}`);
    if (navEl) navEl.classList.add('aktif');
}

/** Render skeleton loading */
function renderLoading() {
    document.getElementById('konten').innerHTML =
        '<div class="state-info"><i class="fa-solid fa-spinner fa-spin"></i> Memuat data...</div>';
}


/* ══════════════════════════════════════════════════════════════════
   ROUTING — muatHalaman()
══════════════════════════════════════════════════════════════════ */
function muatHalaman(seksi) {
    setNavAktif(seksi);
    renderLoading();
    if      (seksi === 'penulis')  muatPenulis();
    else if (seksi === 'artikel')  muatArtikel();
    else if (seksi === 'kategori') muatKategori();
}


/* ══════════════════════════════════════════════════════════════════
   PENULIS — CRUD
══════════════════════════════════════════════════════════════════ */

/** READ — Ambil & render tabel penulis */
async function muatPenulis() {
    try {
        const res  = await fetch('ambil_penulis.php');
        const json = await res.json();

        let html = `
        <div class="seksi-header">
            <h2><i class="fa-solid fa-users"></i> Kelola Penulis</h2>
            <button class="btn btn-primary" onclick="bukaTambahPenulis()"><i class="fa-solid fa-plus"></i> Tambah Penulis</button>
        </div>
        <div class="card">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>`;

        if (!json.data || json.data.length === 0) {
            html += `<tr><td colspan="6" class="state-info">Belum ada data penulis.</td></tr>`;
        } else {
            json.data.forEach((p, i) => {
                const foto = `uploads_penulis/${esc(p.foto)}`;
                html += `
                <tr>
                    <td>${i + 1}</td>
                    <td><img src="${foto}" onerror="this.src='uploads_penulis/default.png'" class="foto-thumb" alt="Foto"></td>
                    <td>${esc(p.nama_depan)} ${esc(p.nama_belakang)}</td>
                    <td>${esc(p.user_name)}</td>
                    <td><span style="font-family:monospace;color:#9e9e9e;font-size:.8rem">${esc(p.password.substring(0,25))}…</span></td>
                    <td class="aksi">
                        <button class="btn btn-warning btn-sm" onclick="bukaEditPenulis(${p.id})"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                        <button class="btn btn-danger  btn-sm" onclick="bukaHapusPenulis(${p.id},'${esc(p.nama_depan)} ${esc(p.nama_belakang)}')"><i class="fa-solid fa-trash-can"></i> Hapus</button>
                    </td>
                </tr>`;
            });
        }

        html += `</tbody></table></div>`;
        document.getElementById('konten').innerHTML = html;

    } catch (err) {
        document.getElementById('konten').innerHTML =
            `<div class="state-info"><i class="fa-solid fa-triangle-exclamation"></i> Gagal memuat data. Periksa koneksi server.</div>`;
    }
}

/** CREATE — Buka modal tambah penulis */
function bukaTambahPenulis() {
    document.getElementById('judul-modal-penulis').textContent  = 'Tambah Penulis';
    document.getElementById('penulis-id').value                 = '';
    document.getElementById('form-penulis').reset();
    document.getElementById('preview-penulis-foto').style.display = 'none';
    document.getElementById('password-required-mark').style.display = 'inline';
    document.getElementById('password-hint').style.display           = 'none';
    document.getElementById('penulis-password').required             = true;
    bukaModal('overlay-penulis');
}

/** UPDATE — Buka modal edit penulis & isi data dari server */
async function bukaEditPenulis(id) {
    try {
        const res  = await fetch(`ambil_satu_penulis.php?id=${id}`);
        const json = await res.json();
        if (!json.sukses) { toast(json.pesan, 'gagal'); return; }

        const p = json.data;
        document.getElementById('judul-modal-penulis').textContent    = 'Edit Penulis';
        document.getElementById('penulis-id').value                   = p.id;
        document.getElementById('penulis-nama-depan').value           = p.nama_depan;
        document.getElementById('penulis-nama-belakang').value        = p.nama_belakang;
        document.getElementById('penulis-username').value             = p.user_name;
        document.getElementById('penulis-password').value             = '';
        document.getElementById('password-required-mark').style.display = 'none';
        document.getElementById('password-hint').style.display           = 'block';
        document.getElementById('penulis-password').required             = false;

        // Tampilkan foto saat ini
        const preview = document.getElementById('preview-penulis-foto');
        preview.src   = `uploads_penulis/${esc(p.foto)}`;
        preview.style.display = 'block';
        preview.onerror = () => { preview.src = 'uploads_penulis/default.png'; };

        bukaModal('overlay-penulis');
    } catch (err) {
        toast('Gagal mengambil data penulis.', 'gagal');
    }
}

/** Simpan / Update Penulis (satu fungsi, cek ada ID atau tidak) */
async function simpanPenulis() {
    const id            = document.getElementById('penulis-id').value.trim();
    const nama_depan    = document.getElementById('penulis-nama-depan').value.trim();
    const nama_belakang = document.getElementById('penulis-nama-belakang').value.trim();
    const user_name     = document.getElementById('penulis-username').value.trim();
    const password      = document.getElementById('penulis-password').value;
    const fotoInput     = document.getElementById('penulis-foto');

    if (!nama_depan || !nama_belakang || !user_name) {
        toast('Nama depan, nama belakang, dan username wajib diisi.', 'gagal'); return;
    }
    if (!id && !password) {
        toast('Password wajib diisi untuk penulis baru.', 'gagal'); return;
    }

    const fd = new FormData();
    fd.append('nama_depan',    nama_depan);
    fd.append('nama_belakang', nama_belakang);
    fd.append('user_name',     user_name);
    fd.append('password',      password);
    if (fotoInput.files[0]) fd.append('foto', fotoInput.files[0]);

    const url = id ? 'update_penulis.php' : 'simpan_penulis.php';
    if (id) fd.append('id', id);

    try {
        const res  = await fetch(url, { method: 'POST', body: fd });
        const json = await res.json();
        toast(json.pesan, json.sukses ? 'sukses' : 'gagal');
        if (json.sukses) { tutupModal('overlay-penulis'); muatPenulis(); }
    } catch (err) {
        toast('Terjadi kesalahan jaringan.', 'gagal');
    }
}

/** DELETE — Buka konfirmasi hapus penulis */
function bukaHapusPenulis(id, nama) {
    document.getElementById('id-hapus-penulis').value   = id;
    document.getElementById('nama-hapus-penulis').textContent = nama;
    bukaModal('overlay-hapus-penulis');
}

/** Eksekusi hapus penulis */
async function eksekusiHapusPenulis() {
    const id = document.getElementById('id-hapus-penulis').value;
    const fd = new FormData();
    fd.append('id', id);

    try {
        const res  = await fetch('hapus_penulis.php', { method: 'POST', body: fd });
        const json = await res.json();
        toast(json.pesan, json.sukses ? 'sukses' : 'gagal');
        if (json.sukses) { tutupModal('overlay-hapus-penulis'); muatPenulis(); }
    } catch (err) {
        toast('Terjadi kesalahan jaringan.', 'gagal');
    }
}


/* ══════════════════════════════════════════════════════════════════
   KATEGORI — CRUD
══════════════════════════════════════════════════════════════════ */

/** READ — Ambil & render tabel kategori */
async function muatKategori() {
    try {
        const res  = await fetch('ambil_kategori.php');
        const json = await res.json();

        let html = `
        <div class="seksi-header">
            <h2><i class="fa-solid fa-folder-open"></i> Kelola Kategori Artikel</h2>
            <button class="btn btn-primary" onclick="bukaTambahKategori()"><i class="fa-solid fa-plus"></i> Tambah Kategori</button>
        </div>
        <div class="card">
        <table>
            <thead>
                <tr><th>#</th><th>Nama Kategori</th><th>Keterangan</th><th>Aksi</th></tr>
            </thead>
            <tbody>`;

        if (!json.data || json.data.length === 0) {
            html += `<tr><td colspan="4" class="state-info">Belum ada data kategori.</td></tr>`;
        } else {
            json.data.forEach((k, i) => {
                html += `
                <tr>
                    <td>${i + 1}</td>
                    <td><span class="badge">${esc(k.nama_kategori)}</span></td>
                    <td style="color:#666;font-size:.85rem">${esc(k.keterangan) || '<em style="color:#ccc">—</em>'}</td>
                    <td class="aksi">
                        <button class="btn btn-warning btn-sm" onclick="bukaEditKategori(${k.id})"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                        <button class="btn btn-danger  btn-sm" onclick="bukaHapusKategori(${k.id},'${esc(k.nama_kategori)}')"><i class="fa-solid fa-trash-can"></i> Hapus</button>
                    </td>
                </tr>`;
            });
        }

        html += `</tbody></table></div>`;
        document.getElementById('konten').innerHTML = html;

    } catch (err) {
        document.getElementById('konten').innerHTML =
            `<div class="state-info"><i class="fa-solid fa-triangle-exclamation"></i> Gagal memuat data. Periksa koneksi server.</div>`;
    }
}

/** CREATE — Buka modal tambah kategori */
function bukaTambahKategori() {
    document.getElementById('judul-modal-kategori').textContent = 'Tambah Kategori';
    document.getElementById('kategori-id').value         = '';
    document.getElementById('kategori-nama').value       = '';
    document.getElementById('kategori-keterangan').value = '';
    bukaModal('overlay-kategori');
}

/** UPDATE — Buka modal edit kategori */
async function bukaEditKategori(id) {
    try {
        const res  = await fetch(`ambil_satu_kategori.php?id=${id}`);
        const json = await res.json();
        if (!json.sukses) { toast(json.pesan, 'gagal'); return; }

        const k = json.data;
        document.getElementById('judul-modal-kategori').textContent = 'Edit Kategori';
        document.getElementById('kategori-id').value         = k.id;
        document.getElementById('kategori-nama').value       = k.nama_kategori;
        document.getElementById('kategori-keterangan').value = k.keterangan || '';
        bukaModal('overlay-kategori');
    } catch (err) {
        toast('Gagal mengambil data kategori.', 'gagal');
    }
}

/** Simpan / Update Kategori */
async function simpanKategori() {
    const id             = document.getElementById('kategori-id').value.trim();
    const nama_kategori  = document.getElementById('kategori-nama').value.trim();
    const keterangan     = document.getElementById('kategori-keterangan').value.trim();

    if (!nama_kategori) { toast('Nama kategori wajib diisi.', 'gagal'); return; }

    const fd = new FormData();
    fd.append('nama_kategori', nama_kategori);
    fd.append('keterangan',    keterangan);

    const url = id ? 'update_kategori.php' : 'simpan_kategori.php';
    if (id) fd.append('id', id);

    try {
        const res  = await fetch(url, { method: 'POST', body: fd });
        const json = await res.json();
        toast(json.pesan, json.sukses ? 'sukses' : 'gagal');
        if (json.sukses) { tutupModal('overlay-kategori'); muatKategori(); }
    } catch (err) {
        toast('Terjadi kesalahan jaringan.', 'gagal');
    }
}

/** DELETE — Buka konfirmasi hapus kategori */
function bukaHapusKategori(id, nama) {
    document.getElementById('id-hapus-kategori').value        = id;
    document.getElementById('nama-hapus-kategori').textContent = nama;
    bukaModal('overlay-hapus-kategori');
}

/** Eksekusi hapus kategori */
async function eksekusiHapusKategori() {
    const id = document.getElementById('id-hapus-kategori').value;
    const fd = new FormData();
    fd.append('id', id);

    try {
        const res  = await fetch('hapus_kategori.php', { method: 'POST', body: fd });
        const json = await res.json();
        toast(json.pesan, json.sukses ? 'sukses' : 'gagal');
        if (json.sukses) { tutupModal('overlay-hapus-kategori'); muatKategori(); }
    } catch (err) {
        toast('Terjadi kesalahan jaringan.', 'gagal');
    }
}


/* ══════════════════════════════════════════════════════════════════
   ARTIKEL — CRUD
══════════════════════════════════════════════════════════════════ */

/** READ — Ambil & render tabel artikel */
async function muatArtikel() {
    try {
        const res  = await fetch('ambil_artikel.php');
        const json = await res.json();

        let html = `
        <div class="seksi-header">
            <h2><i class="fa-solid fa-file-lines"></i> Kelola Artikel</h2>
            <button class="btn btn-primary" onclick="bukaTambahArtikel()"><i class="fa-solid fa-plus"></i> Tambah Artikel</button>
        </div>
        <div class="card">
        <table>
            <thead>
                <tr>
                    <th>#</th><th>Gambar</th><th>Judul</th>
                    <th>Kategori</th><th>Penulis</th><th>Tanggal</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>`;

        if (!json.data || json.data.length === 0) {
            html += `<tr><td colspan="7" class="state-info">Belum ada data artikel.</td></tr>`;
        } else {
            json.data.forEach((a, i) => {
                html += `
                <tr>
                    <td>${i + 1}</td>
                    <td><img src="uploads_artikel/${esc(a.gambar)}" class="gambar-thumb" alt="Gambar" onerror="this.style.display='none'"></td>
                    <td style="font-weight:600;max-width:200px">${esc(a.judul)}</td>
                    <td><span class="badge">${esc(a.nama_kategori)}</span></td>
                    <td>${esc(a.nama_penulis)}</td>
                    <td style="font-size:.8rem;color:#777">${esc(a.hari_tanggal)}</td>
                    <td class="aksi">
                        <button class="btn btn-warning btn-sm" onclick="bukaEditArtikel(${a.id})"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                        <button class="btn btn-danger  btn-sm" onclick="bukaHapusArtikel(${a.id},'${esc(a.judul)}')"><i class="fa-solid fa-trash-can"></i> Hapus</button>
                    </td>
                </tr>`;
            });
        }

        html += `</tbody></table></div>`;
        document.getElementById('konten').innerHTML = html;

    } catch (err) {
        document.getElementById('konten').innerHTML =
            `<div class="state-info"><i class="fa-solid fa-triangle-exclamation"></i> Gagal memuat data. Periksa koneksi server.</div>`;
    }
}

/** Isi dropdown Penulis & Kategori dari database */
async function isiDropdown() {
    const [resPenulis, resKategori] = await Promise.all([
        fetch('ambil_penulis.php'),
        fetch('ambil_kategori.php')
    ]);
    const [jp, jk] = await Promise.all([resPenulis.json(), resKategori.json()]);

    const selPenulis  = document.getElementById('artikel-penulis');
    const selKategori = document.getElementById('artikel-kategori');

    selPenulis.innerHTML  = '<option value="">— Pilih Penulis —</option>';
    selKategori.innerHTML = '<option value="">— Pilih Kategori —</option>';

    (jp.data || []).forEach(p => {
        selPenulis.innerHTML += `<option value="${p.id}">${esc(p.nama_depan)} ${esc(p.nama_belakang)}</option>`;
    });
    (jk.data || []).forEach(k => {
        selKategori.innerHTML += `<option value="${k.id}">${esc(k.nama_kategori)}</option>`;
    });
}

/** CREATE — Buka modal tambah artikel */
async function bukaTambahArtikel() {
    document.getElementById('judul-modal-artikel').textContent = 'Tambah Artikel';
    document.getElementById('artikel-id').value    = '';
    document.getElementById('artikel-judul').value = '';
    document.getElementById('artikel-isi').value   = '';
    document.getElementById('artikel-gambar').value = '';
    document.getElementById('preview-artikel-gambar').style.display = 'none';
    document.getElementById('gambar-required-mark').style.display   = 'inline';

    await isiDropdown();
    bukaModal('overlay-artikel');
}

/** UPDATE — Buka modal edit artikel & isi data dari server */
async function bukaEditArtikel(id) {
    try {
        const res  = await fetch(`ambil_satu_artikel.php?id=${id}`);
        const json = await res.json();
        if (!json.sukses) { toast(json.pesan, 'gagal'); return; }

        const a = json.data;
        document.getElementById('judul-modal-artikel').textContent = 'Edit Artikel';
        document.getElementById('artikel-id').value      = a.id;
        document.getElementById('artikel-judul').value   = a.judul;
        document.getElementById('artikel-isi').value     = a.isi;
        document.getElementById('artikel-gambar').value  = '';
        document.getElementById('gambar-required-mark').style.display = 'none';

        // Preview gambar saat ini
        const prev = document.getElementById('preview-artikel-gambar');
        prev.src   = `uploads_artikel/${esc(a.gambar)}`;
        prev.style.display = 'block';
        prev.onerror = () => { prev.style.display = 'none'; };

        await isiDropdown();

        // Set nilai dropdown
        document.getElementById('artikel-penulis').value  = a.id_penulis;
        document.getElementById('artikel-kategori').value = a.id_kategori;

        bukaModal('overlay-artikel');
    } catch (err) {
        toast('Gagal mengambil data artikel.', 'gagal');
    }
}

/** Simpan / Update Artikel */
async function simpanArtikel() {
    const id          = document.getElementById('artikel-id').value.trim();
    const judul       = document.getElementById('artikel-judul').value.trim();
    const id_penulis  = document.getElementById('artikel-penulis').value;
    const id_kategori = document.getElementById('artikel-kategori').value;
    const isi         = document.getElementById('artikel-isi').value.trim();
    const gambarInput = document.getElementById('artikel-gambar');

    if (!judul || !id_penulis || !id_kategori || !isi) {
        toast('Judul, penulis, kategori, dan isi wajib diisi.', 'gagal'); return;
    }
    if (!id && !gambarInput.files[0]) {
        toast('Gambar wajib diunggah untuk artikel baru.', 'gagal'); return;
    }

    const fd = new FormData();
    fd.append('judul',       judul);
    fd.append('id_penulis',  id_penulis);
    fd.append('id_kategori', id_kategori);
    fd.append('isi',         isi);
    if (gambarInput.files[0]) fd.append('gambar', gambarInput.files[0]);

    const url = id ? 'update_artikel.php' : 'simpan_artikel.php';
    if (id) fd.append('id', id);

    try {
        const res  = await fetch(url, { method: 'POST', body: fd });
        const json = await res.json();
        toast(json.pesan, json.sukses ? 'sukses' : 'gagal');
        if (json.sukses) { tutupModal('overlay-artikel'); muatArtikel(); }
    } catch (err) {
        toast('Terjadi kesalahan jaringan.', 'gagal');
    }
}

/** DELETE — Buka konfirmasi hapus artikel */
function bukaHapusArtikel(id, judul) {
    document.getElementById('id-hapus-artikel').value         = id;
    document.getElementById('judul-hapus-artikel').textContent = judul;
    bukaModal('overlay-hapus-artikel');
}

/** Eksekusi hapus artikel */
async function eksekusiHapusArtikel() {
    const id = document.getElementById('id-hapus-artikel').value;
    const fd = new FormData();
    fd.append('id', id);

    try {
        const res  = await fetch('hapus_artikel.php', { method: 'POST', body: fd });
        const json = await res.json();
        toast(json.pesan, json.sukses ? 'sukses' : 'gagal');
        if (json.sukses) { tutupModal('overlay-hapus-artikel'); muatArtikel(); }
    } catch (err) {
        toast('Terjadi kesalahan jaringan.', 'gagal');
    }
}

/* ══════════════════════════════════════════════════════════════════
   INIT — Muat halaman penulis secara default
══════════════════════════════════════════════════════════════════ */
muatHalaman('penulis');
</script>
</body>
</html>
