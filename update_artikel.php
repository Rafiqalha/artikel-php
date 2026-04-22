<?php
// update_artikel.php — Memperbarui data artikel
require 'koneksi.php';
header('Content-Type: application/json');

$id          = (int)($_POST['id']          ?? 0);
$id_penulis  = (int)($_POST['id_penulis']  ?? 0);
$id_kategori = (int)($_POST['id_kategori'] ?? 0);
$judul       = trim($_POST['judul']        ?? '');
$isi         = trim($_POST['isi']          ?? '');

if (!$id || !$id_penulis || !$id_kategori || !$judul || !$isi) {
    echo json_encode(['sukses' => false, 'pesan' => 'Data tidak lengkap.']);
    exit;
}

// Ambil gambar lama
$stmt = $conn->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$current = $stmt->get_result()->fetch_assoc();
$gambar  = $current['gambar'] ?? '';

// ── Proses Upload Gambar Baru (opsional saat edit) ───────────────────────────
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
    $finfo   = new finfo(FILEINFO_MIME_TYPE);
    $mime    = $finfo->file($_FILES['gambar']['tmp_name']);
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    if (!in_array($mime, $allowed)) {
        echo json_encode(['sukses' => false, 'pesan' => 'Tipe file tidak diizinkan.']);
        exit;
    }
    if ($_FILES['gambar']['size'] > 2 * 1024 * 1024) {
        echo json_encode(['sukses' => false, 'pesan' => 'Ukuran file maksimal 2 MB.']);
        exit;
    }

    // Hapus gambar lama dari server
    if ($gambar && file_exists("uploads_artikel/$gambar")) {
        unlink("uploads_artikel/$gambar");
    }

    $ext    = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
    $gambar = uniqid('artikel_') . '.' . $ext;
    move_uploaded_file($_FILES['gambar']['tmp_name'], "uploads_artikel/$gambar");
}
// ─────────────────────────────────────────────────────────────────────────────

$stmt = $conn->prepare(
    "UPDATE artikel SET id_penulis=?, id_kategori=?, judul=?, isi=?, gambar=? WHERE id=?"
);
$stmt->bind_param('iisssi', $id_penulis, $id_kategori, $judul, $isi, $gambar, $id);

if ($stmt->execute()) {
    echo json_encode(['sukses' => true, 'pesan' => 'Artikel berhasil diperbarui.']);
} else {
    echo json_encode(['sukses' => false, 'pesan' => 'Gagal memperbarui: ' . $conn->error]);
}
