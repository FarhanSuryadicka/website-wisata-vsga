<?php
include 'koneksi.php'; // Koneksi ke database

header('Content-Type: application/json');
header('Content-Disposition: attachment; filename="data_pemesanan.json"');

// Query untuk mendapatkan semua data pemesanan
$sql = "SELECT * FROM pemesanan";
$result = $conn->query($sql);

$pemesananList = [];

if ($result) {
    $pemesananList = $result->fetch_all(MYSQLI_ASSOC);
} else {
    echo json_encode(['error' => 'Tidak bisa mengambil data dari database']);
    exit;
}

// Mengonversi data menjadi JSON dan mengunduhnya
echo json_encode($pemesananList, JSON_PRETTY_PRINT);
?>
