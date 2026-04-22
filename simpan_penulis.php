<?php
// simpan_penulis.php — Menyimpan data penulis baru
require 'koneksi.php';
header('Content-Type: application/json');

$nama_depan    = trim($_POST['nama_depan']    ?? '');
$nama_belakang = trim($_POST['nama_belakang'] ?? '');
$user_name     = trim($_POST['user_name']     ?? '');
$password      = $_POST['password']           ?? '';

if (!$nama_depan || !$nama_belakang || !$user_name || !$password) {
    echo json_encode(['sukses' => false, 'pesan' => 'Semua field wajib diisi.']);
    exit;
}

// ── Proses Upload Foto ────────────────────────────────────────────────────────
$foto = 'default.png';

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $finfo   = new finfo(FILEINFO_MIME_TYPE);                       // validasi via finfo, bukan $_FILES['type']
    $mime    = $finfo->file($_FILES['foto']['tmp_name']);
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    if (!in_array($mime, $allowed)) {
        echo json_encode(['sukses' => false, 'pesan' => 'Tipe file tidak diizinkan. Gunakan JPG, PNG, GIF, atau WEBP.']);
        exit;
    }
    if ($_FILES['foto']['size'] > 2 * 1024 * 1024) {
        echo json_encode(['sukses' => false, 'pesan' => 'Ukuran file maksimal 2 MB.']);
        exit;
    }

    $ext  = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
    $foto = uniqid('penulis_') . '.' . $ext;
    move_uploaded_file($_FILES['foto']['tmp_name'], "uploads_penulis/$foto");
}
// ─────────────────────────────────────────────────────────────────────────────

$hash = password_hash($password, PASSWORD_BCRYPT);

$stmt = $conn->prepare(
    "INSERT INTO penulis (nama_depan, nama_belakang, user_name, password, foto) VALUES (?, ?, ?, ?, ?)"
);
$stmt->bind_param('sssss', $nama_depan, $nama_belakang, $user_name, $hash, $foto);

if ($stmt->execute()) {
    echo json_encode(['sukses' => true, 'pesan' => 'Penulis berhasil ditambahkan.']);
} else {
    if ($conn->errno === 1062) {
        echo json_encode(['sukses' => false, 'pesan' => 'Username sudah digunakan, pilih username lain.']);
    } else {
        echo json_encode(['sukses' => false, 'pesan' => 'Gagal menyimpan: ' . $conn->error]);
    }
}
