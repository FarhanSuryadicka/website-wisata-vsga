<?php
include 'koneksi.php';
include 'header.php';  // Include untuk menampilkan header

// Mendapatkan ID dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo "<script>alert('ID tidak valid.'); window.location.href='pemesanan_index.php';</script>";
    exit;
}

// Query untuk mengambil data pemesanan berdasarkan ID
$sql = "SELECT * FROM pemesanan WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('Data tidak ditemukan.'); window.location.href='pemesanan_index.php';</script>";
    exit;
}

$pemesanan = $result->fetch_assoc();
?>

<div class="container my-5">
    <h2 class="text-center mb-4">Edit Pemesanan Paket Wisata</h2>
    <form action="pemesanan_update.php" method="post" class="p-4 border rounded">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($pemesanan['id']); ?>">

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nama" class="form-label">Nama Pemesan</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($pemesanan['nama']); ?>" readonly>
            </div>
            <div class="col-md-6">
                <label for="no_hp" class="form-label">No HP / Telp</label>
                <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($pemesanan['no_hp']); ?>" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="tgl_booking" class="form-label">Tanggal Pemesanan</label>
                <input type="date" class="form-control" id="tgl_booking" name="tgl_booking" value="<?php echo htmlspecialchars($pemesanan['tgl_booking']); ?>" required>
            </div>
            <div class="col-md-6">
                <label for="durasi" class="form-label">Durasi Pemesanan</label>
                <input type="number" class="form-control" id="durasi" name="durasi" value="<?php echo htmlspecialchars($pemesanan['durasi']); ?>" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="jumlah" class="form-label">Jumlah Pemesanan</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?php echo htmlspecialchars($pemesanan['jumlah']); ?>" required>
            </div>
            <div class="col-md-6">
                <label for="harga_paket" class="form-label">Harga Paket</label>
                <input type="text" class="form-control" id="harga_paket" name="harga_paket" value="<?php echo htmlspecialchars($pemesanan['harga_paket']); ?>" readonly>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="total_tagihan" class="form-label">Jumlah Tagihan</label>
                <input type="text" class="form-control" id="total_tagihan" name="total_tagihan" value="<?php echo htmlspecialchars($pemesanan['total_tagihan']); ?>" readonly>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="pemesanan_index.php" class="btn btn-secondary ms-2">Batal</a>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>
