<?php
include 'koneksi.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="pemesanan_data.csv"');

$output = fopen('php://output', 'w');

// Menambahkan header kolom
fputcsv($output, array('No', 'Nama', 'No HP', 'Tanggal Booking', 'Durasi', 'Jumlah Peserta', 'Harga Paket', 'Total Tagihan'));

// Ambil data dari database
$sql = "SELECT * FROM pemesanan";
$result = $conn->query($sql);
$i = 1;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Menyusun baris data untuk setiap record
        fputcsv($output, array(
            $i++, // Nomor urut
            $row['nama'],
            $row['no_hp'],
            $row['tgl_booking'],
            $row['durasi'],
            $row['jumlah'],
            number_format($row['harga_paket'], 2), // Format harga paket
            number_format($row['total_tagihan'], 2) // Format total tagihan
        ));
    }
}
fclose($output);
?>
