<?php
include 'koneksi.php';
ob_start(); // Start output buffering

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo '<div class="alert alert-danger">ID tidak ditemukan.</div>';
        exit;
    }

    $id = $_GET['id'];

    // Prepare SQL to fetch data
    $sql = "SELECT * FROM galeri_wisata WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo '<div class="alert alert-danger">Data galeri tidak ditemukan.</div>';
        exit;
    }

    $galeri = $result->fetch_assoc();
?>

<h1>Edit Gambar Wisata</h1>

<form action="galeri_edit.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($galeri['id']); ?>">
    <input type="hidden" name="old_gambar" value="<?php echo htmlspecialchars($galeri['gambar']); ?>">
    <div class="mb-3">
        <label for="nama_wisata" class="form-label">Nama Wisata</label>
        <input type="text" class="form-control" id="nama_wisata" name="nama_wisata" value="<?php echo htmlspecialchars($galeri['nama_wisata']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi (Opsional)</label>
        <textarea class="form-control" id="deskripsi" name="deskripsi"><?php echo htmlspecialchars($galeri['deskripsi']); ?></textarea>
    </div>
    <div class="mb-3">
        <label for="gambar" class="form-label">Gambar</label>
        <input type="file" class="form-control" id="gambar" name="gambar">
        <img src="assets/img/galeri/<?php echo htmlspecialchars($galeri['gambar']); ?>" width="100" class="mt-2">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>

<?php
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nama_wisata = $_POST['nama_wisata'];
    $deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : null;  // Deskripsi bisa kosong
    $old_gambar = $_POST['old_gambar'];

    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        $target_dir = "assets/img/galeri/";
        $target_file = $target_dir . basename($gambar);

        // Remove old image if it exists
        if (file_exists($target_dir . $old_gambar)) {
            unlink($target_dir . $old_gambar);
        }

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            $sql = "UPDATE galeri_wisata SET nama_wisata = ?, deskripsi = ?, gambar = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                die("Error preparing statement: " . $conn->error);
            }

            $stmt->bind_param("sssi", $nama_wisata, $deskripsi, $gambar, $id);
        } else {
            echo '<div class="alert alert-danger">Gagal mengupload gambar.</div>';
            exit;
        }
    } else {
        // If no new image, update without changing the image
        $sql = "UPDATE galeri_wisata SET nama_wisata = ?, deskripsi = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("ssi", $nama_wisata, $deskripsi, $id);
    }

    $stmt->execute();
    
    // Redirect to the list page with a success parameter
    header('Location: galeri_index.php?success=edit'); // 'edit' berarti update berhasil
    exit();    
}

$content = ob_get_clean(); // Get the buffered content
include 'template.php'; // Include the template with sidebar and footer
?>
