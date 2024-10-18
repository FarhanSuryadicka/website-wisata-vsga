<?php
include 'koneksi.php';
ob_start(); // Start output buffering

// Pagination settings
$items_per_page = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

// Search functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';
$search = $conn->real_escape_string($search);

// SQL query for pagination and search
$sql = "SELECT * FROM galeri_wisata WHERE nama_wisata LIKE '%$search%' LIMIT $items_per_page OFFSET $offset";
$result = $conn->query($sql);

$total_items_sql = "SELECT COUNT(*) as total FROM galeri_wisata WHERE nama_wisata LIKE '%$search%'";
$total_items_result = $conn->query($total_items_sql);
$total_items = $total_items_result->fetch_assoc()['total'];
$total_pages = ceil($total_items / $items_per_page);

?>
<div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="text-center">Galeri Wisata</h1>
    </div>

    <form class="mb-3 d-flex justify-content-between align-items-center" method="GET" action="">
        <a href="galeri_add.php" class="btn btn-primary mr-3">Tambah Gambar</a>
        <div class="input-group flex-grow-1">
            <input type="text" class="form-control" name="search" placeholder="Cari nama wisata" value="<?php echo htmlspecialchars($search); ?>">
            <button class="btn btn-secondary" type="submit">Cari</button>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Wisata</th>
                <th>Deskripsi</th>
                <th>Gambar</th>
                <th>Tanggal Upload</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result) {
                $no = $offset + 1; // Start numbering from the first item on the current page
                $galeris = $result->fetch_all(MYSQLI_ASSOC);
                foreach ($galeris as $galeri) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($no); ?></td>
                    <td><?php echo htmlspecialchars($galeri['nama_wisata']); ?></td>
                    <td><?php echo htmlspecialchars($galeri['deskripsi']); ?></td>
                    <td><img src="assets/img/galeri/<?php echo htmlspecialchars($galeri['gambar']); ?>" width="100"></td>
                    <td><?php echo htmlspecialchars($galeri['tanggal_upload']); ?></td>
                    <td>
                        <a href="galeri_edit.php?id=<?php echo htmlspecialchars($galeri['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="#" class="btn btn-danger btn-sm delete-btn" data-id="<?php echo htmlspecialchars($galeri['id']); ?>">Hapus</a>
                    </td>
                </tr>
                <?php
                $no++; // Increment No for each row
                endforeach;
            } else {
                echo "<tr><td colspan='6'>Error: " . $conn->error . "</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Pagination controls -->
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                <a class="page-link" href="?search=<?php echo htmlspecialchars($search); ?>&page=<?php echo max(1, $page - 1); ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
            <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                <a class="page-link" href="?search=<?php echo htmlspecialchars($search); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
            <?php endfor; ?>
            <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                <a class="page-link" href="?search=<?php echo htmlspecialchars($search); ?>&page=<?php echo min($total_pages, $page + 1); ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle delete button clicks
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            var id = this.getAttribute('data-id');
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'galeri_delete.php?id=' + id;
                }
            });
        });
    });

    // Check for success or error parameters in URL
    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams.has('success')) {
        const successType = urlParams.get('success');
        let title = '';
        let text = '';

        // Handling based on the success parameter
        switch (successType) {
            case 'add':
                title = 'Berhasil!';
                text = 'Data berhasil ditambahkan.';
                break;
            case 'edit':
                title = 'Berhasil!';
                text = 'Data berhasil diupdate.';
                break;
            case 'delete':
                title = 'Berhasil!';
                text = 'Data berhasil dihapus.';
                break;
        }

        if (title && text) {
            Swal.fire({
                title: title,
                text: text,
                icon: 'success',
                confirmButtonText: 'OK'
            });
        }
    } else if (urlParams.has('error')) {
        const errorType = urlParams.get('error');
        let errorMessage = 'Terjadi kesalahan.';

        if (errorType === 'not_found') {
            errorMessage = 'Data tidak ditemukan.';
        }

        Swal.fire({
            title: 'Gagal!',
            text: errorMessage,
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
});
</script>

<?php
$content = ob_get_clean(); // Get the buffered content
include 'template.php'; // Include the template with sidebar and footer
?>
