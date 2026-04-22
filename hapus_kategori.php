<?php
// hapus_kategori.php — Menghapus data kategori artikel
require 'koneksi.php';
header('Content-Type: application/json');

$id = (int)($_POST['id'] ?? 0);
if (!$id) {
    echo json_encode(['sukses' => false, 'pesan' => 'ID tidak valid.']);
    exit;
}

// Cek apakah kategori masih memiliki artikel
$stmt = $conn->prepare("SELECT COUNT(*) AS jumlah FROM artikel WHERE id_kategori = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if ($row['jumlah'] > 0) {
    echo json_encode(['sukses' => false, 'pesan' => 'Kategori tidak dapat dihapus karena masih memiliki ' . $row['jumlah'] . ' artikel.']);
    exit;
}

$stmt = $conn->prepare("DELETE FROM kategori_artikel WHERE id = ?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    echo json_encode(['sukses' => true, 'pesan' => 'Kategori berhasil dihapus.']);
} else {
    echo json_encode(['sukses' => false, 'pesan' => 'Gagal menghapus: ' . $conn->error]);
}
