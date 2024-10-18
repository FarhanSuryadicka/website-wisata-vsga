<?php 
include 'koneksi.php';
include 'header.php'; 
?>

<!-- Hero Section -->
<section class="hero text-white text-center">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000" data-bs-pause="hover">
        <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active">
                <img src="assets/img/bg/1.jpg" srcset="assets/img/bg/1.jpg 1x, assets/img/bg/1.jpg@2x.jpg 2x" class="d-block w-100" alt="Gambar 1">
                <div class="carousel-caption">
                    <h1>Selamat Datang di Wisata Impian</h1>
                    <p class="lead">Nikmati keindahan alam dan pengalaman wisata yang tak terlupakan bersama kami!</p>
                </div>
            </div>
            <!-- Slide 2 -->
            <div class="carousel-item">
                <img src="assets/img/bg/2.jpg" srcset="assets/img/bg/2.jpg 1x, assets/img/bg/2.jpg@2x.jpg 2x" class="d-block w-100" alt="Gambar 2">
                <div class="carousel-caption">
                    <h1>Petualangan Seru Menanti</h1>
                    <p class="lead">Temukan keindahan tersembunyi di setiap sudut destinasi wisata kami!</p>
                </div>
            </div>
            <!-- Slide 3 -->
            <div class="carousel-item">
                <img src="assets/img/bg/3.jpg" srcset="assets/img/bg/3.jpg 1x, assets/img/bg/3.jpg@2x.jpg 2x" class="d-block w-100" alt="Gambar 3">
                <div class="carousel-caption">
                    <h1>Rasakan Sensasi Berbeda</h1>
                    <p class="lead">Kami hadirkan pengalaman wisata yang penuh kesan, hanya untuk Anda!</p>
                </div>
            </div>
            <!-- Slide 4 -->
            <div class="carousel-item">
                <img src="assets/img/bg/4.jpg" srcset="assets/img/bg/4.jpg 1x, assets/img/bg/4.jpg@2x.jpg 2x" class="d-block w-100" alt="Gambar 4">
                <div class="carousel-caption">
                    <h1>Mari Bergabung Bersama Kami</h1>
                    <p class="lead">Rasakan dan nikmati wisata alam indonesia yang indah!</p>
                </div>
            </div>
        </div>

        <!-- Carousel controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

<!-- Galeri Foto -->
<section id="galeri" class="py-5">
    <div class="container">
        <h2 class="text-center">Galeri Wisata</h2>
        <div class="row">
            <?php
            // Ambil data dari tabel galeri_wisata
            $sql = "SELECT * FROM galeri_wisata";
            $result = $conn->query($sql);

            if ($result) { // Periksa apakah query berhasil
                if ($result->num_rows > 0) {
                    // Output data setiap baris
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-lg-4 col-md-6 mb-4">';
                        echo '<img src="assets/img/galeri/' . htmlspecialchars($row["gambar"]) . '" class="img-fluid rounded" alt="' . htmlspecialchars($row["nama_wisata"]) . '">';
                        echo '</div>';
                    }
                } else {
                    echo '<p class="text-center">Belum ada foto di galeri.</p>';
                }
            } else {
                echo '<p class="text-center">Terjadi kesalahan: ' . $conn->error . '</p>';
            }
            ?>
        </div>
    </div>
</section>

<!-- Video Promosi -->
<section id="video" class="bg-light py-5">
    <div class="container">
        <h2 class="text-center">Video Promosi</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="ratio ratio-16x9">
                <iframe src="https://www.youtube.com/embed/U136nuH0KH8" title="Video Promosi Wisata" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Paket Wisata -->
<section id="paket" class="py-5">
    <div class="container">
        <h2 class="text-center">Paket Wisata</h2>
        <div class="row">
            <?php
            // Ambil data dari tabel paket_wisata
            $sql = "SELECT * FROM paket_wisata";
            $result = $conn->query($sql);

            if ($result) { // Periksa apakah query berhasil
                if ($result->num_rows > 0) {
                    // Output data setiap baris
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-md-4 mb-4">';
                        echo '<div class="card">';
                        echo '<img src="assets/img/paket/' . htmlspecialchars($row["gambar"]) . '" class="card-img-top" alt="' . htmlspecialchars($row["judul"]) . '">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . htmlspecialchars($row["judul"]) . '</h5>';
                        echo '<p class="card-text">' . htmlspecialchars($row["deskripsi"]) . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p class="text-center">Belum ada paket wisata.</p>';
                }
            } else {
                echo '<p class="text-center">Terjadi kesalahan: ' . $conn->error . '</p>';
            }

            // Tutup koneksi
            $conn->close();
            ?>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
