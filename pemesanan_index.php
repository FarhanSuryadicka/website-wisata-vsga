<?php
include 'koneksi.php';
ob_start();

// Tentukan berapa banyak data yang ditampilkan per halaman
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$i = $offset + 1; // Mulai nomor urut berdasarkan halaman saat ini
?>

<div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="text-center">Daftar Pemesanan Paket Wisata</h1>
    </div>

    <!-- Tombol Export JSON berada di bagian atas -->
    <div class="d-flex justify-content-start mb-3">
        <a href="export_json.php" class="btn btn-success">
            <i class="fas fa-file-code"></i> Export JSON
        </a>
    </div>

    <!-- Tombol Export CSV, Excel, PDF, Print, dan Form Pencarian -->
    <div class="d-flex justify-content-between mb-4">
        <div class="btn-group" role="group" aria-label="Export options">
            <a href="export_csv.php" class="btn btn-info">
                <i class="fas fa-file-csv"></i> Export CSV
            </a>
            <a href="export_excel.php" class="btn btn-primary">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
            <a href="export_pdf.php" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
            <a href="javascript:window.print()" class="btn btn-warning">
                <i class="fas fa-print"></i> Print
            </a>
        </div>

        <!-- Form Pencarian di sebelah tombol Print -->
        <form class="d-flex" method="GET" action="">
            <input type="text" class="form-control me-2" name="search" placeholder="Cari pemesanan" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button class="btn btn-secondary" type="submit">Cari</button>
        </form>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>No HP</th>
                <th>Tanggal Booking</th>
                <th>Durasi</th>
                <th>Jumlah Peserta</th>
                <th>Harga Paket</th>
                <th>Total Tagihan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $search = $conn->real_escape_string($search);

            // Query untuk menghitung total data
            $sql_count = "SELECT COUNT(*) AS total FROM pemesanan WHERE nama LIKE '%$search%' OR no_hp LIKE '%$search%'";
            $result_count = $conn->query($sql_count);
            $total_data = $result_count->fetch_assoc()['total'];

            // Hitung total halaman
            $total_pages = ceil($total_data / $limit);

            // Query untuk mengambil data dengan limit dan offset
            $sql = "SELECT * FROM pemesanan WHERE nama LIKE '%$search%' OR no_hp LIKE '%$search%' LIMIT $limit OFFSET $offset";
            $result = $conn->query($sql);

            if ($result) {
                $pemesanans = $result->fetch_all(MYSQLI_ASSOC);
                foreach ($pemesanans as $pemesanan) : ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo htmlspecialchars($pemesanan['nama']); ?></td>
                        <td><?php echo htmlspecialchars($pemesanan['no_hp']); ?></td>
                        <td><?php echo htmlspecialchars($pemesanan['tgl_booking']); ?></td>
                        <td><?php echo htmlspecialchars($pemesanan['durasi']); ?></td>
                        <td><?php echo htmlspecialchars($pemesanan['jumlah']); ?></td>
                        <td><?php echo htmlspecialchars($pemesanan['harga_paket']); ?></td>
                        <td><?php echo htmlspecialchars($pemesanan['total_tagihan']); ?></td>
                        <td>
                            <a href="pemesanan_edit.php?id=<?php echo htmlspecialchars($pemesanan['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm delete-btn" data-id="<?php echo htmlspecialchars($pemesanan['id']); ?>">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach;
            } else {
                echo "<tr><td colspan='9'>Error: " . $conn->error . "</td></tr>";
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

<!-- SweetAlert Confirmation for Deletion -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- Link untuk icon fontawesome -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-btn').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            var id = this.getAttribute('data-id');
            
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data ini tidak dapat dikembalikan setelah dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'pemesanan_delete.php?id=' + id;
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
        switch (successType) {
            case '1':
                title = 'Deleted!';
                text = 'Data berhasil dihapus.';
                break;
            case '2':
                title = 'Updated';
                text = 'Data berhasil diupdate';
        }
        if (title && text) {
            Swal.fire(title, text, 'success');
        }
    } else if (urlParams.has('error')) {
        let errorMessage = 'Terjadi kesalahan.';
        switch (urlParams.get('error')) {
            case 'invalid_id':
                errorMessage = 'ID tidak valid.';
                break;
        }
        Swal.fire('Error!', errorMessage, 'error');
    }
});
</script>

<?php
$content = ob_get_clean();
include 'template.php';
?>
