<?php
// Konfigurasi database
$host = 'localhost';
$db = 'wisata';
$user = 'root';
$pass = '';

// Buat koneksi ke database
$conn = new mysqli($host, $user, $pass, $db);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
