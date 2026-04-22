<?php
// update_kategori.php — Memperbarui data kategori artikel
require 'koneksi.php';
header('Content-Type: application/json');

$id            = (int)($_POST['id']            ?? 0);
$nama_kategori = trim($_POST['nama_kategori'] ?? '');
$keterangan    = trim($_POST['keterangan']    ?? '');

if (!$id || !$nama_kategori) {
    echo json_encode(['sukses' => false, 'pesan' => 'Data tidak lengkap.']);
    exit;
}

$stmt = $conn->prepare("UPDATE kategori_artikel SET nama_kategori=?, keterangan=? WHERE id=?");
$stmt->bind_param('ssi', $nama_kategori, $keterangan, $id);

if ($stmt->execute()) {
    echo json_encode(['sukses' => true, 'pesan' => 'Kategori berhasil diperbarui.']);
} else {
    if ($conn->errno === 1062) {
        echo json_encode(['sukses' => false, 'pesan' => 'Nama kategori sudah ada.']);
    } else {
        echo json_encode(['sukses' => false, 'pesan' => 'Gagal memperbarui: ' . $conn->error]);
    }
}
