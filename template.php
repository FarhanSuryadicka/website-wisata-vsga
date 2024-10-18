<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wisata Impian - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Tambahkan SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<!-- Sidebar Navbar for Dashboard -->
<nav class="sidebar" id="sidebar">
    <div class="text-center"> Halaman Admin</div>
    <hr class="sidebar-divider"> <!-- Divider Line -->
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="template.php">
                <i class="fas fa-home"></i> <span class="link-text">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="paket_index.php">
                <i class="fas fa-suitcase-rolling"></i> <span class="link-text">Paket Wisata</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="galeri_index.php">
                <i class="fas fa-images"></i> <span class="link-text">Galeri Wisata</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="pemesanan_index.php">
                <i class="fas fa-receipt"></i> <span class="link-text">Pemesanan</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link" id="logoutBtn">
                <i class="fas fa-sign-out-alt"></i> <span class="link-text">Logout</span>
            </a>
        </li>
    </ul>
    <div class="sidebar-header">
        <button id="sidebarToggle" class="btn btn-outline-light">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</nav>

<!-- Main Content Wrapper -->
<div class="content-wrapper">
    <main class="main-content">
        <!-- Page content will be injected here -->
        <?php echo isset($content) ? $content : ''; ?>
    </main>
</div>

<!-- Footer -->
<footer class="bg-dark text-white py-4">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="footer-left">
            <p class="mb-0 copyright-text">&copy; 2024 Wisata Impian. All rights reserved.</p>
        </div>
        <div class="social-icons">
            <a href="https://www.facebook.com/profile.php?id=100074179090256" target="_blank" class="text-white mx-2" style="text-decoration: none;">
                <i class="fa-brands fa-facebook fa-2x"></i>
            </a>
            <a href="https://github.com/FarhanSuryadicka" target="_blank" class="text-white mx-2" style="text-decoration: none;">
                <i class="fa-brands fa-github fa-2x"></i>
            </a>
            <a href="https://www.instagram.com/frhnsydka?igsh=MTdoeHYwdWF2OXprMA==" target="_blank" class="text-white mx-2" style="text-decoration: none;">
                <i class="fa-brands fa-instagram fa-2x"></i>
            </a>
            <a href="https://linkedin.com" target="_blank" class="text-white mx-2" style="text-decoration: none;">
                <i class="fa-brands fa-linkedin-in fa-2x"></i>
            </a>
        </div>
    </div>
</footer>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/sidebar-toggle.js"></script>

<!-- SweetAlert Logout Confirmation -->
<script>
    document.getElementById('logoutBtn').addEventListener('click', function (e) {
        e.preventDefault(); // Mencegah link langsung dijalankan
        
        // SweetAlert Konfirmasi
        Swal.fire({
            title: 'Apakah Anda yakin ingin logout?',
            text: "Anda akan keluar dari sesi ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, logout!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Arahkan ke halaman logout jika dikonfirmasi
                window.location.href = 'logout.php';
            }
        })
    });
</script>

</body>
</html>
