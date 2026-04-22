<?php
// ambil_satu_penulis.php — Mengambil satu data penulis berdasarkan ID (untuk form edit)
require 'koneksi.php';
header('Content-Type: application/json');

$id = (int)($_GET['id'] ?? 0);
if (!$id) {
    echo json_encode(['sukses' => false, 'pesan' => 'ID tidak valid.']);
    exit;
}

$stmt = $conn->prepare("SELECT id, nama_depan, nama_belakang, user_name, foto FROM penulis WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$row    = $result->fetch_assoc();

if ($row) {
    echo json_encode(['sukses' => true, 'data' => $row]);
} else {
    echo json_encode(['sukses' => false, 'pesan' => 'Data tidak ditemukan.']);
}
