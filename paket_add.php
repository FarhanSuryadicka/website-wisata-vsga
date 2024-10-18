<?php
include 'koneksi.php';
ob_start(); // Start output buffering
?>

<h1>Tambah Paket Wisata</h1>

<form action="paket_add.php" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="judul" class="form-label">Judul</label>
        <input type="text" class="form-control" id="judul" name="judul" required>
    </div>
    <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
    </div>
    <div class="mb-3">
        <label for="gambar" class="form-label">Gambar</label>
        <input type="file" class="form-control" id="gambar" name="gambar" required>
    </div>
    <button type="submit" class="btn btn-primary">Tambah</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = $_FILES['gambar']['name'];
    $target_dir = "assets/img/paket/";
    $target_file = $target_dir . basename($gambar);

    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
        $sql = "INSERT INTO paket_wisata (judul, deskripsi, gambar) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param('sss', $judul, $deskripsi, $gambar);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            $stmt->close();
            header('Location: paket_index.php?success=2'); // Redirect with success parameter
            exit();
        } else {
            echo '<div class="alert alert-danger">Gagal menambahkan paket wisata.</div>';
        }
        $stmt->close();
    } else {
        echo '<div class="alert alert-danger">Gagal mengupload gambar.</div>';
    }
}

$content = ob_get_clean(); // Get the buffered content
include 'template.php'; // Include the template with sidebar and footer
?>
