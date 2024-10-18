<?php
include 'koneksi.php';
ob_start(); // Start output buffering
?>

<h1>Tambah Gambar Wisata</h1>

<form action="galeri_add.php" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="nama_wisata" class="form-label">Nama Wisata</label>
        <input type="text" class="form-control" id="nama_wisata" name="nama_wisata" required>
    </div>
    <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi (Opsional)</label>
        <textarea class="form-control" id="deskripsi" name="deskripsi"></textarea>
    </div>
    <div class="mb-3">
        <label for="gambar" class="form-label">Gambar</label>
        <input type="file" class="form-control" id="gambar" name="gambar" required>
    </div>
    <button type="submit" class="btn btn-primary">Tambah</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_wisata = $_POST['nama_wisata'];
    $deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : null;  // Deskripsi bisa kosong
    $gambar = $_FILES['gambar']['name'];
    $target_dir = "assets/img/galeri/";
    $target_file = $target_dir . basename($gambar);

    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
        $sql = "INSERT INTO galeri_wisata (nama_wisata, deskripsi, gambar) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param('sss', $nama_wisata, $deskripsi, $gambar);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            $stmt->close();
            header('Location: galeri_index.php?success=add'); // Redirect with success parameter
            exit();
        } else {
            echo '<div class="alert alert-danger">Gagal menambahkan gambar wisata.</div>';
        }
        $stmt->close();
    } else {
        echo '<div class="alert alert-danger">Gagal mengupload gambar.</div>';
    }
}

$content = ob_get_clean(); // Get the buffered content
include 'template.php'; // Include the template with sidebar and footer
?>
