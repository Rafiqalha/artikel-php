<?php
// koneksi.php — Koneksi ke database MySQL menggunakan mysqli

$host = 'localhost';
$db   = 'db_blog';
$user = 'root';
$pass = '';           // Sesuaikan dengan password MySQL kamu

// Coba buat koneksi dengan menggunakan try/catch atau check connect_error dengan mengabaikan koneksi awal
try {
    // Matikan mode exception bawaan sementar untuk mysqli agar tidak menghasilkan fatal error
    mysqli_report(MYSQLI_REPORT_OFF);
    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode(['sukses' => false, 'pesan' => 'Koneksi gagal: ' . $conn->connect_error]);
        exit;
    }

    $conn->set_charset('utf8mb4');
} catch (Exception $e) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['sukses' => false, 'pesan' => 'Koneksi gagal: ' . $e->getMessage()]);
    exit;
}
