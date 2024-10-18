<?php
include 'koneksi.php';
session_start(); // Start session to use flash messages

// Validate and sanitize the input
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Prepare statement to retrieve the image file name
    $sql = "SELECT gambar FROM paket_wisata WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $paket = $result->fetch_assoc();

    if ($paket) {
        $gambar = $paket['gambar'];
        $target_file = "assets/img/paket/" . $gambar;

        // Delete the file if it exists
        if (file_exists($target_file)) {
            unlink($target_file);
        }

        // Prepare statement to delete the record
        $sql = "DELETE FROM paket_wisata WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Redirect with success parameter
        header('Location: paket_index.php?success=1');
        exit();
    } else {
        // Redirect with error parameter if record not found
        header('Location: paket_index.php?error=not_found');
        exit();
    }
} else {
    // Redirect with error parameter for invalid ID
    header('Location: paket_index.php?error=invalid_id');
    exit();
}
?>
