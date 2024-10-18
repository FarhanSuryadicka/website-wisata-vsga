<?php
include 'koneksi.php';
ob_start();
?>

<h1>Form Pemesanan Paket Wisata</h1>

<form action="pemesanan_add.php" method="post">
    <!-- Nama Pemesan and No HP -->
    <div class="row mb-3">
        <div class="col">
            <label for="nama" class="form-label">Nama Pemesan</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Isi Nama Pemesan" required>
        </div>
        <div class="col">
            <label for="no_hp" class="form-label">No HP / Telp</label>
            <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Isi No HP / Telp" required>
        </div>
    </div>

    <!-- Tanggal Pemesanan and Durasi Pemesanan -->
    <div class="row mb-3">
        <div class="col">
            <label for="tgl_booking" class="form-label">Tanggal Pemesanan</label>
            <input type="date" class="form-control" id="tgl_booking" name="tgl_booking" required>
        </div>
        <div class="col">
            <label for="durasi" class="form-label">Durasi Pemesanan</label>
            <input type="number" class="form-control" id="durasi" name="durasi" placeholder="Isi Durasi Pemesanan" required>
        </div>
    </div>

    <!-- Jumlah Pemesanan -->
    <div class="row mb-3">
        <div class="col">
            <label for="jumlah" class="form-label">Jumlah Pemesanan</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah Pemesan" required>
        </div>
    </div>

    <!-- Pelayanan Paket Perjalanan Section -->
    <div class="mb-3">
        <label for="pelayanan" class="form-label">Pelayanan Paket Perjalanan</label>
        <div class="row">
            <div class="col">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Penginapan</h5>
                        <p class="card-text">Rp1.000.000</p>
                        <input type="checkbox" id="penginapan" name="penginapan" value="1000000" onclick="calculateTotal()"> Pilih Penginapan
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Transportasi</h5>
                        <p class="card-text">Rp1.200.000</p>
                        <input type="checkbox" id="transportasi" name="transportasi" value="1200000" onclick="calculateTotal()"> Pilih Transportasi
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Makanan</h5>
                        <p class="card-text">Rp500.000</p>
                        <input type="checkbox" id="makanan" name="makanan" value="500000" onclick="calculateTotal()"> Pilih Makanan
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Tagihan -->
    <div class="row mb-3">
        <div class="col">
            <label for="total_tagihan" class="form-label">Total Tagihan</label>
            <input type="text" class="form-control" id="total_tagihan" name="total_tagihan" placeholder="Rp" readonly>
        </div>
    </div>

    <!-- Submit and Reset Buttons -->
    <div class="d-flex justify-content-between">
        <button type="reset" class="btn btn-warning">Reset</button>
        <button type="submit" class="btn btn-primary">Process</button>
    </div>
</form>

<script>
    function calculateTotal() {
        var total = 0;

        // Check if the user selected Penginapan, Transportasi, or Makanan
        if (document.getElementById('penginapan').checked) {
            total += parseInt(document.getElementById('penginapan').value);
        }
        if (document.getElementById('transportasi').checked) {
            total += parseInt(document.getElementById('transportasi').value);
        }
        if (document.getElementById('makanan').checked) {
            total += parseInt(document.getElementById('makanan').value);
        }

        // Update the total tagihan field
        document.getElementById('total_tagihan').value = "Rp" + total.toLocaleString();
    }
</script>

<?php
// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $tgl_booking = $_POST['tgl_booking'];
    $durasi = $_POST['durasi'];
    $jumlah = $_POST['jumlah'];

    // Calculate total from selected services
    $penginapan = isset($_POST['penginapan']) ? $_POST['penginapan'] : 0;
    $transportasi = isset($_POST['transportasi']) ? $_POST['transportasi'] : 0;
    $makanan = isset($_POST['makanan']) ? $_POST['makanan'] : 0;
    
    // Calculate the total cost
    $total_tagihan = $penginapan + $transportasi + $makanan;

    // Insert query
    $sql = "INSERT INTO pemesanan (nama, no_hp, tgl_booking, durasi, jumlah, harga_paket, total_tagihan) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssiiss', $nama, $no_hp, $tgl_booking, $durasi, $jumlah, $total_tagihan, $total_tagihan);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        header('Location: pemesanan_index.php?success=added');
        exit();
    } else {
        echo '<div class="alert alert-danger">Gagal menambahkan pemesanan.</div>';
    }
    $stmt->close();
}

$content = ob_get_clean();
include 'template.php';  // Include sidebar and footer from template.php
?>
