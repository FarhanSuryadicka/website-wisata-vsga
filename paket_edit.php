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
    $sql = "SELECT * FROM paket_wisata WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo '<div class="alert alert-danger">Paket tidak ditemukan.</div>';
        exit;
    }

    $paket = $result->fetch_assoc();
?>

<h1>Edit Paket Wisata</h1>

<form action="paket_edit.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($paket['id']); ?>">
    <input type="hidden" name="old_gambar" value="<?php echo htmlspecialchars($paket['gambar']); ?>">
    <div class="mb-3">
        <label for="judul" class="form-label">Judul</label>
        <input type="text" class="form-control" id="judul" name="judul" value="<?php echo htmlspecialchars($paket['judul']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea class="form-control" id="deskripsi" name="deskripsi" required><?php echo htmlspecialchars($paket['deskripsi']); ?></textarea>
    </div>
    <div class="mb-3">
        <label for="gambar" class="form-label">Gambar</label>
        <input type="file" class="form-control" id="gambar" name="gambar">
        <img src="assets/img/paket/<?php echo htmlspecialchars($paket['gambar']); ?>" width="100" class="mt-2">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>

<?php
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $old_gambar = $_POST['old_gambar'];

    if (!empty($_FILES['gambar']['name'])) {
        $gambar = $_FILES['gambar']['name'];
        $target_dir = "assets/img/paket/";
        $target_file = $target_dir . basename($gambar);

        // Remove old image if it exists
        if (file_exists($target_dir . $old_gambar) && $old_gambar != 'default.jpg') {
            unlink($target_dir . $old_gambar);
        }

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            $sql = "UPDATE paket_wisata SET judul = ?, deskripsi = ?, gambar = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                die("Error preparing statement: " . $conn->error);
            }

            $stmt->bind_param("sssi", $judul, $deskripsi, $gambar, $id);
        } else {
            echo '<div class="alert alert-danger">Gagal mengupload gambar.</div>';
            exit;
        }
    } else {
        // If no new image, update without changing the image
        $sql = "UPDATE paket_wisata SET judul = ?, deskripsi = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("ssi", $judul, $deskripsi, $id);
    }

    $stmt->execute();
    
    // Redirect to the list page with a success parameter
    header('Location: paket_index.php?success=3'); // '3' berarti update berhasil
    exit();    
}

$content = ob_get_clean(); // Get the buffered content
include 'template.php'; // Include the template with sidebar and footer
?>
