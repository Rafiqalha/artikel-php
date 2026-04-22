<?php
// ambil_satu_kategori.php — Mengambil satu data kategori berdasarkan ID (untuk form edit)
require 'koneksi.php';
header('Content-Type: application/json');

$id = (int)($_GET['id'] ?? 0);
if (!$id) {
    echo json_encode(['sukses' => false, 'pesan' => 'ID tidak valid.']);
    exit;
}

$stmt = $conn->prepare("SELECT id, nama_kategori, keterangan FROM kategori_artikel WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if ($row) {
    echo json_encode(['sukses' => true, 'data' => $row]);
} else {
    echo json_encode(['sukses' => false, 'pesan' => 'Data tidak ditemukan.']);
}
