<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Wisata Impian</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#galeri">Galeri Wisata</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#video">Video Promosi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#paket">Paket Wisata</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="form-pemesanan.php">Pemesanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kalkulator.php">Kalkulator</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="calculator-container">
        <h2>Kalkulator Sederhana</h2>

        <form method="post">
            <label for="angka1">Angka 1:</label>
            <input type="text" id="angka1" name="angka1" required>

            <label for="operator">Pilih Operator:</label>
            <select id="operator" name="operator" required>
                <option value="Penjumlahan">Penjumlahan</option>
                <option value="Pengurangan">Pengurangan</option>
                <option value="Perkalian">Perkalian</option>
                <option value="Pembagian">Pembagian</option>
            </select>

            <label for="angka2">Angka 2:</label>
            <input type="text" id="angka2" name="angka2" required>

            <input type="submit" name="submit" value="Hitung">
        </form>

        <?php
        if(isset($_POST['submit'])){
            $angka1 = $_POST['angka1'];
            $angka2 = $_POST['angka2'];
            $operator = $_POST['operator'];

            if(is_numeric($angka1) && is_numeric($angka2)){
                switch($operator){
                    case "Penjumlahan":
                        $hasil = $angka1 + $angka2;
                        break;
                    case "Pengurangan":
                        $hasil = $angka1 - $angka2;
                        break;
                    case "Perkalian":
                        $hasil = $angka1 * $angka2;
                        break;
                    case "Pembagian":
                        if($angka2 != 0){
                            $hasil = $angka1 / $angka2;
                        } else {
                            $hasil = "Tidak bisa membagi dengan nol!";
                        }
                        break;
                    default:
                        $hasil = "Operator tidak valid!";
                }
                echo "<h3>Hasil: $hasil</h3>";
            } else {
                echo "<h3>Masukkan angka yang valid!</h3>";
            }
        }
        ?>
    </div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-4">
    <p>&copy; 2024 Wisata Impian. All rights reserved.</p>
    <div class="social-icons">
        <a href="https://facebook.com" target="blank" class="text-white mx-2">
            <i class="fab fa-facebook-f"></i>
        </a>
        <a href="https://twitter.com" target="blank" class="text-white mx-2">
            <i class="fab fa-twitter"></i>
        </a>
        <a href="https://instagram.com" target="blank" class="text-white mx-2">
            <i class="fab fa-instagram"></i>
        </a>
        <a href="https://linkedin.com" target="blank" class="text-white mx-2">
            <i class="fab fa-linkedin-in"></i>
        </a>
    </div>
</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
