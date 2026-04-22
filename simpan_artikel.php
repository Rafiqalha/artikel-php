<?php
// simpan_artikel.php — Menyimpan data artikel baru
require 'koneksi.php';
header('Content-Type: application/json');

$id_penulis  = (int)($_POST['id_penulis']  ?? 0);
$id_kategori = (int)($_POST['id_kategori'] ?? 0);
$judul       = trim($_POST['judul']        ?? '');
$isi         = trim($_POST['isi']          ?? '');

if (!$id_penulis || !$id_kategori || !$judul || !$isi) {
    echo json_encode(['sukses' => false, 'pesan' => 'Semua field wajib diisi.']);
    exit;
}

// Gambar wajib diupload untuk artikel baru
if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['sukses' => false, 'pesan' => 'Gambar artikel wajib diunggah.']);
    exit;
}

$finfo   = new finfo(FILEINFO_MIME_TYPE);
$mime    = $finfo->file($_FILES['gambar']['tmp_name']);
$allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

if (!in_array($mime, $allowed)) {
    echo json_encode(['sukses' => false, 'pesan' => 'Tipe file tidak diizinkan. Gunakan JPG, PNG, GIF, atau WEBP.']);
    exit;
}
if ($_FILES['gambar']['size'] > 2 * 1024 * 1024) {
    echo json_encode(['sukses' => false, 'pesan' => 'Ukuran file maksimal 2 MB.']);
    exit;
}

$ext    = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
$gambar = uniqid('artikel_') . '.' . $ext;
move_uploaded_file($_FILES['gambar']['tmp_name'], "uploads_artikel/$gambar");

// ── Auto-generate hari_tanggal dari server (sesuai ketentuan soal) ────────────
date_default_timezone_set('Asia/Jakarta');
$hari   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
$bulan  = [
    1=>'Januari', 2=>'Februari', 3=>'Maret',    4=>'April',
    5=>'Mei',     6=>'Juni',     7=>'Juli',     8=>'Agustus',
    9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
];
$sekarang     = new DateTime();
$nama_hari    = $hari[$sekarang->format('w')];
$tanggal      = $sekarang->format('j');
$nama_bulan   = $bulan[(int)$sekarang->format('n')];
$tahun        = $sekarang->format('Y');
$jam          = $sekarang->format('H:i');
$hari_tanggal = "$nama_hari, $tanggal $nama_bulan $tahun | $jam";
// ─────────────────────────────────────────────────────────────────────────────

$stmt = $conn->prepare(
    "INSERT INTO artikel (id_penulis, id_kategori, judul, isi, gambar, hari_tanggal) VALUES (?, ?, ?, ?, ?, ?)"
);
$stmt->bind_param('iissss', $id_penulis, $id_kategori, $judul, $isi, $gambar, $hari_tanggal);

if ($stmt->execute()) {
    echo json_encode(['sukses' => true, 'pesan' => 'Artikel berhasil ditambahkan.']);
} else {
    echo json_encode(['sukses' => false, 'pesan' => 'Gagal menyimpan: ' . $conn->error]);
}
