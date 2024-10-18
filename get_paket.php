<?php
header('Content-Type: application/json');

// Konfigurasi database
$host = 'localhost';       // Ganti dengan hostname database Anda jika berbeda
$user = 'root';            // Ganti dengan username database Anda
$password = '';            // Ganti dengan password database Anda
$database = 'wisata';      // Ganti dengan nama database Anda

// Buat koneksi ke database
$conn = new mysqli($host, $user, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die(json_encode(array('error' => 'Koneksi gagal: ' . $conn->connect_error)));
}

// Ambil data dari tabel paket_wisata
$sql = 'SELECT * FROM paket_wisata';
$result = $conn->query($sql);

$paket_wisata = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $paket_wisata[] = $row;
    }
} else {
    $paket_wisata = array('message' => 'Tidak ada data.');
}

// Kirim data dalam format JSON
echo json_encode($paket_wisata);

// Tutup koneksi
$conn->close();
?>
