<?php
require('fpdf186/fpdf.php');
include 'koneksi.php';

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Judul tabel
$pdf->Cell(190, 10, 'Daftar Pemesanan Paket Wisata', 1, 1, 'C');

// Header tabel
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 10, 'No', 1);
$pdf->Cell(40, 10, 'Nama', 1);
$pdf->Cell(30, 10, 'No HP', 1);
$pdf->Cell(30, 10, 'Tanggal Booking', 1);
$pdf->Cell(20, 10, 'Durasi', 1);
$pdf->Cell(20, 10, 'Jumlah', 1);
$pdf->Cell(40, 10, 'Total Tagihan', 1);
$pdf->Ln();

// Ambil data dari database
$sql = "SELECT * FROM pemesanan";
$result = $conn->query($sql);
$i = 1;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(10, 10, $i++, 1);
        $pdf->Cell(40, 10, $row['nama'], 1);
        $pdf->Cell(30, 10, $row['no_hp'], 1);
        $pdf->Cell(30, 10, $row['tgl_booking'], 1);
        $pdf->Cell(20, 10, $row['durasi'], 1);
        $pdf->Cell(20, 10, $row['jumlah'], 1);
        $pdf->Cell(40, 10, $row['total_tagihan'], 1);
        $pdf->Ln();
    }
}

$pdf->Output('D', 'pemesanan_data.pdf');
?>
