<?php
// Sertakan file koneksi
include 'koneksi.php';

// Ambil data dari form
$nama = $conn->real_escape_string($_POST['name']);
$no_hp = $conn->real_escape_string($_POST['phone']);
$tgl_booking = $conn->real_escape_string($_POST['booking_date']);
$durasi = (int)$_POST['duration'];
$jumlah = (int)$_POST['quantity'];
$harga_paket = str_replace(['Rp ', '.'], '', $_POST['package_price']); // Menghapus format Rp dan titik
$total_tagihan = str_replace(['Rp ', '.'], '', $_POST['total_bill']); // Menghapus format Rp dan titik

// Masukkan data ke tabel
$sql = "INSERT INTO pemesanan (nama, no_hp, tgl_booking, durasi, jumlah, harga_paket, total_tagihan)
        VALUES ('$nama', '$no_hp', '$tgl_booking', $durasi, $jumlah, $harga_paket, $total_tagihan)";

if ($conn->query($sql) === TRUE) {
    // Data berhasil disimpan
    // Tidak perlu output di sini, karena modal akan menampilkan ringkasan
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
