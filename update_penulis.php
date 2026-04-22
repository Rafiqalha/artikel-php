<?php
// update_penulis.php — Memperbarui data penulis
require 'koneksi.php';
header('Content-Type: application/json');

$id            = (int)($_POST['id']            ?? 0);
$nama_depan    = trim($_POST['nama_depan']    ?? '');
$nama_belakang = trim($_POST['nama_belakang'] ?? '');
$user_name     = trim($_POST['user_name']     ?? '');
$password      = $_POST['password']           ?? '';

if (!$id || !$nama_depan || !$nama_belakang || !$user_name) {
    echo json_encode(['sukses' => false, 'pesan' => 'Data tidak lengkap.']);
    exit;
}

// Ambil foto lama
$stmt = $conn->prepare("SELECT foto FROM penulis WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$current = $stmt->get_result()->fetch_assoc();
$foto    = $current['foto'] ?? 'default.png';

// ── Proses Upload Foto Baru ───────────────────────────────────────────────────
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $finfo   = new finfo(FILEINFO_MIME_TYPE);
    $mime    = $finfo->file($_FILES['foto']['tmp_name']);
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    if (!in_array($mime, $allowed)) {
        echo json_encode(['sukses' => false, 'pesan' => 'Tipe file tidak diizinkan.']);
        exit;
    }
    if ($_FILES['foto']['size'] > 2 * 1024 * 1024) {
        echo json_encode(['sukses' => false, 'pesan' => 'Ukuran file maksimal 2 MB.']);
        exit;
    }

    // Hapus foto lama jika bukan default
    if ($foto !== 'default.png' && file_exists("uploads_penulis/$foto")) {
        unlink("uploads_penulis/$foto");
    }

    $ext  = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
    $foto = uniqid('penulis_') . '.' . $ext;
    move_uploaded_file($_FILES['foto']['tmp_name'], "uploads_penulis/$foto");
}
// ─────────────────────────────────────────────────────────────────────────────

if ($password) {
    // Jika password diisi, update beserta password baru
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare(
        "UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, password=?, foto=? WHERE id=?"
    );
    $stmt->bind_param('sssssi', $nama_depan, $nama_belakang, $user_name, $hash, $foto, $id);
} else {
    // Jika password kosong, biarkan password lama
    $stmt = $conn->prepare(
        "UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, foto=? WHERE id=?"
    );
    $stmt->bind_param('ssssi', $nama_depan, $nama_belakang, $user_name, $foto, $id);
}

if ($stmt->execute()) {
    echo json_encode(['sukses' => true, 'pesan' => 'Penulis berhasil diperbarui.']);
} else {
    if ($conn->errno === 1062) {
        echo json_encode(['sukses' => false, 'pesan' => 'Username sudah digunakan.']);
    } else {
        echo json_encode(['sukses' => false, 'pesan' => 'Gagal memperbarui: ' . $conn->error]);
    }
}
