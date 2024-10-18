<?php 
include 'header.php'; 
?>

<div class="container my-5">
    <h2 class="text-center mb-4">Form Pemesanan Paket Wisata</h2>
    <form id="bookingForm" action="data-pemesanan.php" method="post" class="p-4 border rounded">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Nama Pemesan</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Isi Nama Pemesan" required>
            </div>
            <div class="col-md-6">
                <label for="phone" class="form-label">No HP / Telp</label>
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Isi No HP / Telp" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="booking_date" class="form-label">Tanggal Pemesanan</label>
                <input type="date" class="form-control" id="booking_date" name="booking_date" placeholder="dd/mm/yyyy" required>
            </div>
            <div class="col-md-6">
                <label for="duration" class="form-label">Durasi Pemesanan</label>
                <input type="number" class="form-control" id="duration" name="duration" placeholder="Isi Durasi Pemesanan" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="quantity" class="form-label">Jumlah Pemesanan</label>
                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Jumlah Pemesan" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Pelayanan Paket Perjalanan</label>
                <div class="d-flex justify-content-between">
                    <div class="card service-card text-center" data-service="penginapan">
                        <div class="card-body">
                            <h5 class="card-title">Penginapan</h5>
                            <p class="card-text">Rp1.000.000</p>
                        </div>
                    </div>
                    <div class="card service-card text-center" data-service="transportasi">
                        <div class="card-body">
                            <h5 class="card-title">Transportasi</h5>
                            <p class="card-text">Rp1.200.000</p>
                        </div>
                    </div>
                    <div class="card service-card text-center" data-service="makanan">
                        <div class="card-body">
                            <h5 class="card-title">Makanan</h5>
                            <p class="card-text">Rp500.000</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="package_price" class="form-label">Harga Paket</label>
                <input type="text" class="form-control" id="package_price" name="package_price" placeholder="Rp" readonly>
            </div>
            <div class="col-md-6">
                <label for="total_bill" class="form-label">Jumlah Tagihan</label>
                <input type="text" class="form-control" id="total_bill" name="total_bill" placeholder="Rp" readonly>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button type="button" id="processButton" class="btn btn-primary">Process</button>
            <button type="reset" class="btn btn-danger ms-2">Reset</button>
        </div>
    </form>
</div>

<!-- Modal -->
<div class="modal fade" id="summaryModal" tabindex="-1" aria-labelledby="summaryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="summaryModalLabel">Rangkuman Pemesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nama Pemesan:</strong> <span id="modalName"></span></p>
                <p><strong>No HP / Telp:</strong> <span id="modalPhone"></span></p>
                <p><strong>Tanggal Pemesanan:</strong> <span id="modalDate"></span></p>
                <p><strong>Durasi Pemesanan:</strong> <span id="modalDuration"></span> hari</p>
                <p><strong>Jumlah Pemesanan:</strong> <span id="modalQuantity"></span> orang</p>
                <p><strong>Harga Paket:</strong> <span id="modalPackagePrice"></span></p>
                <p><strong>Jumlah Tagihan:</strong> <span id="modalTotalBill"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" id="saveButton" class="btn btn-primary">Simpan</button>
                <button type="button" id="editButton" class="btn btn-secondary">Edit</button>
                <button type="button" id="printButton" class="btn btn-primary d-none">Cetak</button>
                <button type="button" id="closeModalButton" class="btn btn-secondary d-none" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    function formatRupiah(amount) {
        return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function calculateTotal() {
        let quantity = document.getElementById('quantity').value;
        let duration = document.getElementById('duration').value;
        let selectedServices = document.querySelectorAll('.service-card.selected');
        let services = Array.from(selectedServices).map(card => card.getAttribute('data-service'));

        if (!quantity || !duration || services.length === 0) {
            document.getElementById('package_price').value = '';
            document.getElementById('total_bill').value = '';
            return;
        }

        let pricePerService = {
            'penginapan': 1000000,
            'transportasi': 1200000,
            'makanan': 500000
        };

        let packagePrice = services.reduce((total, service) => total + pricePerService[service], 0);
        let totalBill = packagePrice * duration * quantity;

        document.getElementById('package_price').value = 'Rp ' + formatRupiah(packagePrice);
        document.getElementById('total_bill').value = 'Rp ' + formatRupiah(totalBill);
    }

    document.querySelectorAll('.service-card').forEach(card => {
        card.addEventListener('click', function() {
            this.classList.toggle('selected');
            this.classList.toggle('bg-primary');
            this.classList.toggle('text-white');
            calculateTotal();
        });
    });

    document.getElementById('quantity').addEventListener('input', calculateTotal);
    document.getElementById('duration').addEventListener('input', calculateTotal);

    // Trigger modal after clicking Process
    document.getElementById('processButton').addEventListener('click', function() {
        let name = document.getElementById('name').value;
        let phone = document.getElementById('phone').value;
        let bookingDate = document.getElementById('booking_date').value;
        let duration = document.getElementById('duration').value;
        let quantity = document.getElementById('quantity').value;
        let packagePrice = document.getElementById('package_price').value;
        let totalBill = document.getElementById('total_bill').value;

        document.getElementById('modalName').textContent = name;
        document.getElementById('modalPhone').textContent = phone;
        document.getElementById('modalDate').textContent = bookingDate;
        document.getElementById('modalDuration').textContent = duration;
        document.getElementById('modalQuantity').textContent = quantity;
        document.getElementById('modalPackagePrice').textContent = packagePrice;
        document.getElementById('modalTotalBill').textContent = totalBill;

        const summaryModal = new bootstrap.Modal(document.getElementById('summaryModal'));
        summaryModal.show();
    });

    // Save button: Save the data to the server
    document.getElementById('saveButton').addEventListener('click', function() {
        let name = document.getElementById('name').value;
        let phone = document.getElementById('phone').value;
        let bookingDate = document.getElementById('booking_date').value;
        let duration = document.getElementById('duration').value;
        let quantity = document.getElementById('quantity').value;
        let packagePrice = document.getElementById('package_price').value;
        let totalBill = document.getElementById('total_bill').value;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'data-pemesanan.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('saveButton').disabled = true;
                document.getElementById('editButton').disabled = true;
                document.getElementById('printButton').classList.remove('d-none');
                document.getElementById('closeModalButton').classList.remove('d-none');
            }
        };

        xhr.send(`name=${name}&phone=${phone}&booking_date=${bookingDate}&duration=${duration}&quantity=${quantity}&package_price=${packagePrice}&total_bill=${totalBill}`);
    });

    // Edit button: Go back to form
    document.getElementById('editButton').addEventListener('click', function() {
        const summaryModal = bootstrap.Modal.getInstance(document.getElementById('summaryModal'));
        summaryModal.hide();
    });

    // Fungsi untuk clear data form ketika modal ditutup
    document.getElementById('closeModalButton').addEventListener('click', function() {
        // Clear all form fields
        document.getElementById('bookingForm').reset();

        // Remove selected service cards styles
        document.querySelectorAll('.service-card').forEach(card => {
            card.classList.remove('selected', 'bg-primary', 'text-white');
        });

        // Clear the price and bill fields
        document.getElementById('package_price').value = '';
        document.getElementById('total_bill').value = '';
    });

    // Fungsi untuk mencetak
    document.getElementById('printButton').addEventListener('click', function() {
        const selectedServices = document.querySelectorAll('.service-card.selected');
        const services = Array.from(selectedServices).map(card => card.querySelector('.card-title').textContent).join(', ');

        const layananPaket = services.length ? services : 'Tidak ada layanan yang dipilih';

        const printContent = `
            <html>
            <head>
                <title>Cetak Rangkuman</title>
                <style>
                    body {
                        font-family: 'Arial', sans-serif;
                        margin: 20px;
                        background-color: #f9f9f9;
                        color: #333;
                    }
                    .container {
                        width: 70%;
                        margin: 0 auto;
                        padding: 20px;
                        background-color: #fff;
                        border-radius: 8px;
                        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
                    }
                    .header {
                        background-color: #ff8c42;
                        padding: 15px;
                        text-align: center;
                        font-weight: bold;
                        font-size: 1.5rem;
                        color: white;
                        border-radius: 8px 8px 0 0;
                    }
                    .summary-table {
                        width: 100%;
                        margin-top: 20px;
                        border-collapse: collapse;
                    }
                    .summary-table tr {
                        display: flex;
                        justify-content: space-between;
                        padding: 10px 0;
                    }
                    .summary-table tr:not(:last-child) {
                        border-bottom: 1px solid #ddd;
                    }
                    .summary-table td {
                        padding: 10px;
                        font-size: 1.1rem;
                    }
                    .label {
                        color: #555;
                        font-weight: bold;
                        width: 40%;
                        text-align: left;
                    }
                    .value {
                        color: #000;
                        width: 60%;
                        text-align: right;
                    }
                    .footer {
                        text-align: center;
                        margin-top: 20px;
                        font-size: 0.9rem;
                        color: #888;
                    }
                    .highlight {
                        color: #ff8c42;
                        font-weight: bold;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">RANGKUMAN RESERVASI PAKET WISATA</div>
                    <table class="summary-table">
                        <tr>
                            <td class="label">Nama Pemesan</td>
                            <td class="value">${document.getElementById('modalName').textContent}</td>
                        </tr>
                        <tr>
                            <td class="label">Jumlah Peserta</td>
                            <td class="value">${document.getElementById('modalQuantity').textContent} orang</td>
                        </tr>
                        <tr>
                            <td class="label">Waktu Perjalanan</td>
                            <td class="value">${document.getElementById('modalDuration').textContent} hari</td>
                        </tr>
                        <tr>
                            <td class="label">Layanan Paket</td>
                            <td class="value">${layananPaket}</td>
                        </tr>
                        <tr>
                            <td class="label">Harga Paket</td>
                            <td class="value highlight">${document.getElementById('modalPackagePrice').textContent}</td>
                        </tr>
                        <tr>
                            <td class="label">Jumlah Tagihan</td>
                            <td class="value highlight">${document.getElementById('modalTotalBill').textContent}</td>
                        </tr>
                    </table>
                    <div class="footer">Terima kasih telah menggunakan layanan kami!</div>
                </div>
            </body>
            </html>
        `;

        const printWindow = window.open('', '_blank');
        printWindow.document.open();
        printWindow.document.write(printContent);
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
    });
</script>

<style>
    .service-card {
        cursor: pointer;
        width: 28%; /* Adjusted width for smaller size */
        margin: 0.3rem; /* Reduced margin for compact layout */
        transition: transform 0.2s;
        font-size: 0.9rem; /* Smaller text size */
        padding: 0.5rem; /* Added padding to adjust content spacing */
    }

    .service-card:hover {
        transform: scale(1.05);
    }

    .service-card.selected {
        border: 2px solid #007bff;
        background-color: #007bff;
        color: white;
    }

    .card-body {
        padding: 0.4rem; /* Reduced padding inside the card */
    }

    .card-title {
        font-size: 1rem; /* Smaller title size */
        margin-bottom: 0.2rem; /* Less margin under the title */
    }

    .card-text {
        font-size: 0.9rem; /* Smaller text size */
        margin: 0; /* Removed margin for text */
    }
</style>

<?php 
include 'footer.php'; 
?>
