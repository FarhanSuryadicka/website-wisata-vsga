<?php
include 'koneksi.php';  // Koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $id = $_POST['id'];
    $no_hp = $_POST['no_hp'];
    $tgl_booking = $_POST['tgl_booking'];
    $durasi = $_POST['durasi'];
    $jumlah = $_POST['jumlah'];
    $harga_paket = str_replace('.', '', $_POST['harga_paket']);  // Menghapus titik format rupiah
    $total_tagihan = str_replace('.', '', $_POST['total_tagihan']);  // Menghapus titik format rupiah

    // Update query
    $sql = "UPDATE pemesanan SET no_hp = ?, tgl_booking = ?, durasi = ?, jumlah = ?, harga_paket = ?, total_tagihan = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    // Bind parameter ke query
    $stmt->bind_param("ssiiisi", $no_hp, $tgl_booking, $durasi, $jumlah, $harga_paket, $total_tagihan, $id);

    // Eksekusi query
    if ($stmt->execute()) {
        // Redirect ke halaman index setelah berhasil update
        header('Location: pemesanan_index.php?success=1');
        exit();
    } else {
        echo '<div class="alert alert-danger">Update gagal: ' . htmlspecialchars($stmt->error) . '</div>';
    }

    $stmt->close();  // Tutup statement
}

$conn->close();  // Tutup koneksi
?>
