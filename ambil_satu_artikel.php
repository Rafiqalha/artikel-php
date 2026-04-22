<?php
// ambil_satu_artikel.php — Mengambil satu artikel berdasarkan ID (untuk form edit)
require 'koneksi.php';
header('Content-Type: application/json');

$id = (int)($_GET['id'] ?? 0);
if (!$id) {
    echo json_encode(['sukses' => false, 'pesan' => 'ID tidak valid.']);
    exit;
}

$stmt = $conn->prepare(
    "SELECT id, id_penulis, id_kategori, judul, isi, gambar, hari_tanggal FROM artikel WHERE id = ?"
);
$stmt->bind_param('i', $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if ($row) {
    echo json_encode(['sukses' => true, 'data' => $row]);
} else {
    echo json_encode(['sukses' => false, 'pesan' => 'Data tidak ditemukan.']);
}
