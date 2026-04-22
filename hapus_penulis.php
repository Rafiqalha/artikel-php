<?php
// hapus_penulis.php — Menghapus data penulis
require 'koneksi.php';
header('Content-Type: application/json');

$id = (int)($_POST['id'] ?? 0);
if (!$id) {
    echo json_encode(['sukses' => false, 'pesan' => 'ID tidak valid.']);
    exit;
}

// Cek apakah penulis masih memiliki artikel
$stmt = $conn->prepare("SELECT COUNT(*) AS jumlah FROM artikel WHERE id_penulis = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if ($row['jumlah'] > 0) {
    echo json_encode(['sukses' => false, 'pesan' => 'Penulis tidak dapat dihapus karena masih memiliki ' . $row['jumlah'] . ' artikel.']);
    exit;
}

// Ambil nama foto sebelum dihapus
$stmt = $conn->prepare("SELECT foto FROM penulis WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$penulis = $stmt->get_result()->fetch_assoc();

// Hapus data
$stmt = $conn->prepare("DELETE FROM penulis WHERE id = ?");
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    // Hapus file foto dari server (jika bukan default)
    if ($penulis && $penulis['foto'] !== 'default.png') {
        $path = "uploads_penulis/{$penulis['foto']}";
        if (file_exists($path)) {
            unlink($path);
        }
    }
    echo json_encode(['sukses' => true, 'pesan' => 'Penulis berhasil dihapus.']);
} else {
    echo json_encode(['sukses' => false, 'pesan' => 'Gagal menghapus: ' . $conn->error]);
}
