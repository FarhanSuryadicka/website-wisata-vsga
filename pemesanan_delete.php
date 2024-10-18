<?php
include 'koneksi.php';

// Check if 'id' is present and valid
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $sql = "DELETE FROM pemesanan WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Redirect to pemesanan_index.php with success message
    header("Location: pemesanan_index.php?success=1");
    exit();
} else {
    // Redirect to pemesanan_index.php with error message
    header("Location: pemesanan_index.php?error=invalid_id");
    exit();
}
?>
