<?php
// hapus_artikel.php — Menghapus artikel beserta file gambarnya
require 'koneksi.php';
header('Content-Type: application/json');

$id = (int)($_POST['id'] ?? 0);
if (!$id) {
    echo json_encode(['sukses' => false, 'pesan' => 'ID tidak valid.']);
    exit;
}

// Ambil nama gambar sebelum dihapus
$stmt = $conn->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$artikel = $stmt->get_result()->fetch_assoc();

// Hapus data dari database
$stmt = $conn->prepare("DELETE FROM artikel WHERE id = ?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    // Hapus file gambar dari server
    if ($artikel && $artikel['gambar']) {
        $path = "uploads_artikel/{$artikel['gambar']}";
        if (file_exists($path)) {
            unlink($path);
        }
    }
    echo json_encode(['sukses' => true, 'pesan' => 'Artikel berhasil dihapus.']);
} else {
    echo json_encode(['sukses' => false, 'pesan' => 'Gagal menghapus: ' . $conn->error]);
}
