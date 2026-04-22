<?php
// ambil_kategori.php — Mengambil semua data kategori artikel
require 'koneksi.php';
header('Content-Type: application/json');

$sql    = "SELECT id, nama_kategori, keterangan FROM kategori_artikel ORDER BY id DESC";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(['sukses' => true, 'data' => $data]);
