<?php
include 'koneksi.php';
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=pemesanan_data.xls");

// Membuat tabel HTML untuk format Excel
echo '<table border="1">';
echo '<tr>';
echo '<th>No</th>';
echo '<th>Nama</th>';
echo '<th>No HP</th>';
echo '<th>Tanggal Booking</th>';
echo '<th>Durasi</th>';
echo '<th>Jumlah Peserta</th>';
echo '<th>Harga Paket</th>';
echo '<th>Total Tagihan</th>';
echo '</tr>';

$sql = "SELECT * FROM pemesanan";
$result = $conn->query($sql);
$i = 1;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $i++ . '</td>';
        echo '<td>' . htmlspecialchars($row['nama']) . '</td>';
        echo '<td>' . htmlspecialchars($row['no_hp']) . '</td>';
        echo '<td>' . htmlspecialchars($row['tgl_booking']) . '</td>';
        echo '<td>' . htmlspecialchars($row['durasi']) . '</td>';
        echo '<td>' . htmlspecialchars($row['jumlah']) . '</td>';
        echo '<td>' . number_format($row['harga_paket'], 2) . '</td>';
        echo '<td>' . number_format($row['total_tagihan'], 2) . '</td>';
        echo '</tr>';
    }
}

echo '</table>';
?>
