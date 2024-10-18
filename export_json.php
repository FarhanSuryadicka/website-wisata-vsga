<?php
include 'koneksi.php';

// Ambil data dari database
$sql = "SELECT * FROM pemesanan";
$result = $conn->query($sql);

$pemesanan_data = array();
$i = 1;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Struktur data yang lebih rapi dan deskriptif
        $pemesanan_data[] = array(
            'No' => $i++,
            'Nama' => $row['nama'],
            'No_HP' => $row['no_hp'],
            'Tanggal_Booking' => $row['tgl_booking'],
            'Durasi' => $row['durasi'],
            'Jumlah_Peserta' => $row['jumlah'],
            'Harga_Paket' => number_format($row['harga_paket'], 2),
            'Total_Tagihan' => number_format($row['total_tagihan'], 2)
        );
    }
}

// Set header untuk file JSON
header('Content-Type: application/json');
header('Content-Disposition: attachment;filename="pemesanan_data.json"');

// Tampilkan data dalam format JSON yang rapi
echo json_encode($pemesanan_data, JSON_PRETTY_PRINT);
?>
