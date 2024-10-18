<?php
session_start();

// Sertakan file koneksi database
require 'koneksi.php';

// Ambil data dari form
$username = $_POST['username'];
$password = md5($_POST['password']); // Perhatikan: gunakan `password_hash` dan `password_verify` untuk keamanan yang lebih baik

// Escape input untuk menghindari SQL Injection
$username = $conn->real_escape_string($username);
$password = $conn->real_escape_string($password);

// Query untuk memeriksa kredensial
$sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    // Jika kredensial benar
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    header("Location: template.php"); // Arahkan ke halaman selamat datang atau dashboard
    exit();
} else {
    // Jika kredensial salah
    $error_message = 'Username atau password salah';
    header("Location: login.php?error=" . urlencode($error_message)); // Arahkan kembali ke halaman login dengan pesan kesalahan
    exit();
}

// Tutup koneksi
$conn->close();
?>
