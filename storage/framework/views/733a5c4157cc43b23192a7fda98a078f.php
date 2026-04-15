<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<title>Kasir - Pembayaran</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f3f3f3;
}

/* SIDEBAR */
.sidebar {
    width: 220px;
    height: 100vh;
    background: #e32222;
    position: fixed;
    color: white;
    padding: 20px;
    display: flex;
    flex-direction: column;
}

.sidebar h3 {
    font-weight: bold;
    margin-bottom: 30px;
}

.sidebar a {
    display: block;
    background: #c81d1d;
    padding: 12px;
    margin-bottom: 10px;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: all 0.3s;
}

.sidebar a:hover {
    background: #a81818;
    transform: translateX(5px);
}

/* Menu logout di bagian bawah sidebar */
.sidebar .menu-spacer {
    flex: 1;
}

.sidebar .logout-link {
    background: #8b1a1a;
    margin-top: 20px;
    border-top: 1px solid rgba(255,255,255,0.2);
    padding-top: 15px;
}

.sidebar .logout-link:hover {
    background: #6b1313;
}

.sidebar .logout-link i {
    margin-right: 8px;
}

/* CONTENT */
.content {
    margin-left: 220px;
    padding: 30px;
}

/* TABLE */
.table thead {
    background: #e32222;
    color: white;
}

.total {
    font-size: 20px;
    font-weight: bold;
    margin-top: 20px;
}

.btn-konfirmasi {
    background: #28a745;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s;
    width: 200px;
    font-size: 16px;
    font-weight: bold;
}

.btn-konfirmasi:hover {
    background: #218838;
    transform: scale(1.02);
}

/* Style untuk box kembalian */
.kembalian-box {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    margin-top: 15px;
    border-left: 4px solid #28a745;
}

.kembalian-box .label {
    font-size: 14px;
    color: #666;
    margin-bottom: 5px;
}

.kembalian-box .value {
    font-size: 24px;
    font-weight: bold;
    color: #28a745;
}

.kembalian-box .value.kurang {
    color: #dc3545;
}

.info-text {
    font-size: 12px;
    color: #666;
    margin-top: 5px;
}

/* Alert logout */
.logout-alert {
    position: fixed;
    top: 20px;
    right: 20px;
    background: #28a745;
    color: white;
    padding: 12px 20px;
    border-radius: 8px;
    display: none;
    z-index: 9999;
    animation: slideIn 0.3s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

/* Style untuk metode pembayaran - SELECT DROPDOWN */
.metode-pembayaran {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-top: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.metode-pembayaran h5 {
    color: #e32222;
    margin-bottom: 15px;
    font-weight: bold;
}

.metode-pembayaran select {
    width: 100%;
    max-width: 350px;
    padding: 12px 15px;
    border: 2px solid #dee2e6;
    border-radius: 10px;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s;
    background-color: #f8f9fa;
}

.metode-pembayaran select:focus {
    outline: none;
    border-color: #28a745;
    box-shadow: 0 0 0 3px rgba(40,167,69,0.1);
}

/* Info metode pembayaran */
.info-metode {
    background: #e7f3ff;
    padding: 12px 15px;
    border-radius: 8px;
    margin-top: 10px;
    display: none;
    font-size: 13px;
    border-left: 3px solid #2196F3;
}

.info-metode i {
    margin-right: 8px;
}

/* QRIS DISPLAY LANGSUNG - TAMPILAN QR CODE */
.qris-display {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-top: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    text-align: center;
    display: none;
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.qris-display h5 {
    color: #e32222;
    margin-bottom: 15px;
    font-weight: bold;
}

.qris-card {
    background: #f8f9fa;
    border-radius: 16px;
    padding: 25px;
    display: inline-block;
    width: 100%;
    max-width: 350px;
    margin: 0 auto;
}

.qris-image {
    width: 250px;
    height: 250px;
    margin: 0 auto 20px;
    background: white;
    border-radius: 20px;
    padding: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.qris-image img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.qris-amount {
    font-size: 18px;
    font-weight: bold;
    color: #28a745;
    margin: 15px 0;
}

.qris-amount span {
    font-size: 24px;
    color: #e32222;
}

.qris-instruction {
    font-size: 12px;
    color: #666;
    margin-top: 10px;
}

.btn-qris-confirm {
    background: #28a745;
    color: white;
    border: none;
    padding: 10px 25px;
    border-radius: 8px;
    margin-top: 15px;
    cursor: pointer;
    font-weight: bold;
    transition: all 0.3s;
}

.btn-qris-confirm:hover {
    background: #218838;
    transform: scale(1.02);
}

/* Group pembayaran tunai */
.pembayaran-group {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-top: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    display: none;
}

.pembayaran-group label {
    font-weight: bold;
    margin-bottom: 8px;
    display: block;
}

.pembayaran-group input {
    border: 2px solid #dee2e6;
    border-radius: 8px;
    padding: 10px;
    width: 100%;
    max-width: 300px;
}

/* Timer untuk QRIS */
.qris-timer {
    font-size: 12px;
    color: #ff9800;
    margin-top: 10px;
}

.countdown {
    font-weight: bold;
    font-size: 16px;
    color: #e32222;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h3>🍝 Kasir</h3>

    <a href="<?php echo e(route('dashboard')); ?>">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
    
   

    <div class="menu-spacer"></div>

    <div class="logout-link">
        <a href="#" onclick="confirmLogout(event)" style="display: flex; align-items: center;">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>
</div>

<!-- CONTENT -->
<div class="content">

    <h2 style="color:#e32222;"><b>💳 Pembayaran</b></h2>

    <p>Pelanggan: <b id="namaPelanggan">-</b></p>

    <!-- TABLE -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Menu</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody id="dataMenu">
        </tbody>
    </table>

    <!-- TOTAL -->
    <div class="total">
        Total: <span style="color:red;" id="totalHarga">Rp0</span>
    </div>

    <!-- METODE PEMBAYARAN - DROPDOWN SELECT -->
    <div class="metode-pembayaran">
        <h5>🏧 Pilih Metode Pembayaran</h5>
        <select id="metodeBayar" onchange="ubahMetodePembayaran()">
            <option value="">-- Pilih Metode Pembayaran --</option>
            <option value="Tunai">💵 Tunai (Pembayaran Langsung)</option>
            <option value="QRIS">📱 QRIS (Scan QR Code)</option>
            <option value="Debit">💳 Debit / Kartu Kredit</option>
            <option value="E-Wallet">📲 E-Wallet (OVO/GoPay/DANA)</option>
        </select>
        <div id="infoMetode" class="info-metode"></div>
    </div>

    <!-- INPUT BAYAR TUNAI (hanya muncul jika pilih Tunai) -->
    <div id="pembayaranGroup" class="pembayaran-group">
        <label for="pembayaran">Jumlah Pembayaran (Tunai)</label>
        <input type="number" id="pembayaran" class="form-control" placeholder="Masukkan jumlah pembayaran" oninput="hitungKembalian()">
    </div>

    <!-- BOX KEMBALIAN -->
    <div class="kembalian-box" id="kembalianBox" style="display: none;">
        <div class="label">Kembalian</div>
        <div class="value" id="kembalianValue">Rp0</div>
        <div class="info-text" id="infoKembalian"></div>
    </div>

    <!-- QRIS DISPLAY LANGSUNG (muncul saat pilih QRIS) -->
    <div id="qrisDisplay" class="qris-display">
        <h5>📱 Scan QR Code Berikut</h5>
        <div class="qris-card">
            <div class="qris-image">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Crect width='100' height='100' fill='%23000'/%3E%3Crect x='10' y='10' width='30' height='30' fill='white'/%3E%3Crect x='60' y='10' width='30' height='30' fill='white'/%3E%3Crect x='10' y='60' width='30' height='30' fill='white'/%3E%3Crect x='60' y='60' width='30' height='30' fill='white'/%3E%3C/svg%3E" alt="QR Code">
            </div>
            <div class="qris-amount">
                Total Pembayaran: <span id="qrisTotal">Rp0</span>
            </div>
            <div class="qris-timer" id="qrisTimer">
                ⏱️ QR Code berlaku selama: <span class="countdown" id="countdown">05:00</span>
            </div>
            <div class="qris-instruction">
                <i class="bi bi-phone"></i> Buka aplikasi pembayaran (OVO/GoPay/DANA/ShopeePay/Mandiri)<br>
                Pilih QRIS, lalu scan QR Code di atas
            </div>
            <button class="btn-qris-confirm" onclick="confirmQRISPayment()">
                ✅ Konfirmasi Setelah Scan
            </button>
        </div>
    </div>

    <!-- BUTTON KONFIRMASI -->
    <button class="btn btn-konfirmasi mt-3" onclick="konfirmasiPesanan()" id="btnKonfirmasi">Konfirmasi Pembayaran</button>

</div>

<!-- Alert notifikasi -->
<div id="logoutAlert" class="logout-alert">
    ✅ Logout berhasil! Mengalihkan ke halaman login...
</div>

<script>
let orderDataGlobal = null;
let totalHargaGlobal = 0;
let metodeTerpilih = '';
let qrisTimerInterval = null;

function formatRupiah(angka){
    if (angka === undefined || angka === null) return '0';
    return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g,".");
}

function startQRISCountdown() {
    // Hentikan timer sebelumnya jika ada
    if (qrisTimerInterval) {
        clearInterval(qrisTimerInterval);
    }
    
    let timeLeft = 300; // 5 menit dalam detik
    let countdownElement = document.getElementById('countdown');
    
    function updateCountdown() {
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;
        countdownElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        
        if (timeLeft <= 0) {
            clearInterval(qrisTimerInterval);
            countdownElement.textContent = "00:00";
            countdownElement.style.color = "#dc3545";
            
            // Tampilkan notifikasi QR Code expired
            Swal.fire({
                icon: 'warning',
                title: 'QR Code Expired',
                text: 'Waktu scan QR Code telah habis. Silakan pilih ulang metode QRIS.',
                confirmButtonColor: '#e32222'
            }).then(() => {
                // Reset metode
                document.getElementById('metodeBayar').value = '';
                ubahMetodePembayaran();
            });
        }
        timeLeft--;
    }
    
    updateCountdown();
    qrisTimerInterval = setInterval(updateCountdown, 1000);
}

function stopQRISCountdown() {
    if (qrisTimerInterval) {
        clearInterval(qrisTimerInterval);
        qrisTimerInterval = null;
    }
}

function ubahMetodePembayaran() {
    let select = document.getElementById('metodeBayar');
    let metode = select.value;
    metodeTerpilih = metode;
    
    let pembayaranGroup = document.getElementById('pembayaranGroup');
    let kembalianBox = document.getElementById('kembalianBox');
    let infoMetode = document.getElementById('infoMetode');
    let btnKonfirmasi = document.getElementById('btnKonfirmasi');
    let qrisDisplay = document.getElementById('qrisDisplay');
    
    // Reset tampilan
    pembayaranGroup.style.display = 'none';
    kembalianBox.style.display = 'none';
    qrisDisplay.style.display = 'none';
    stopQRISCountdown();
    
    if (!metode) {
        infoMetode.style.display = 'none';
        btnKonfirmasi.disabled = true;
        btnKonfirmasi.style.opacity = '0.5';
        btnKonfirmasi.style.cursor = 'not-allowed';
        return;
    }
    
    btnKonfirmasi.disabled = false;
    btnKonfirmasi.style.opacity = '1';
    btnKonfirmasi.style.cursor = 'pointer';
    
    // Tampilkan sesuai metode
    let infoText = '';
    switch(metode) {
        case 'Tunai':
            infoText = '💡 Silakan masukkan jumlah uang yang dibayarkan pelanggan. Sistem akan menghitung kembalian secara otomatis.';
            pembayaranGroup.style.display = 'block';
            document.getElementById('pembayaran').value = '';
            document.getElementById('pembayaran').required = true;
            break;
        case 'QRIS':
            infoText = '📱 Scan QR Code di bawah ini menggunakan aplikasi pembayaran Anda. QR Code berlaku selama 5 menit.';
            qrisDisplay.style.display = 'block';
            document.getElementById('qrisTotal').innerText = 'Rp' + formatRupiah(totalHargaGlobal);
            startQRISCountdown();
            break;
        case 'Debit':
            infoText = '💳 Pembayaran menggunakan Kartu Debit/Kredit. Pastikan mesin EDC tersedia. Klik konfirmasi setelah pembayaran selesai.';
            break;
        case 'E-Wallet':
            infoText = '📲 Pembayaran menggunakan E-Wallet (OVO, GoPay, DANA, dll). Klik konfirmasi setelah pembayaran selesai.';
            break;
    }
    
    infoMetode.innerHTML = '<i class="bi bi-info-circle"></i> ' + infoText;
    infoMetode.style.display = 'block';
}

function hitungKembalian() {
    let metode = document.getElementById('metodeBayar').value;
    
    if (metode !== 'Tunai') {
        return;
    }
    
    let bayar = parseInt(document.getElementById('pembayaran').value);
    let total = totalHargaGlobal;
    let kembalianBox = document.getElementById('kembalianBox');
    let kembalianValue = document.getElementById('kembalianValue');
    let infoKembalian = document.getElementById('infoKembalian');
    let btnKonfirmasi = document.getElementById('btnKonfirmasi');
    
    if (isNaN(bayar) || bayar === "") {
        kembalianBox.style.display = "none";
        btnKonfirmasi.disabled = false;
        btnKonfirmasi.style.opacity = "1";
        btnKonfirmasi.style.cursor = "pointer";
        return;
    }
    
    let kembalian = bayar - total;
    
    if (bayar < total) {
        kembalianValue.innerHTML = `Rp${formatRupiah(Math.abs(kembalian))}`;
        kembalianValue.className = "value kurang";
        infoKembalian.innerHTML = "⚠️ Pembayaran masih kurang! Silakan tambah nominal.";
        kembalianBox.style.display = "block";
        btnKonfirmasi.disabled = true;
        btnKonfirmasi.style.opacity = "0.5";
        btnKonfirmasi.style.cursor = "not-allowed";
    } else {
        kembalianValue.innerHTML = `Rp${formatRupiah(kembalian)}`;
        kembalianValue.className = "value";
        
        if (kembalian === 0) {
            infoKembalian.innerHTML = "✓ Pembayaran pas, tidak ada kembalian";
        } else {
            infoKembalian.innerHTML = "✓ Pembayaran berhasil, berikut kembaliannya";
        }
        
        kembalianBox.style.display = "block";
        btnKonfirmasi.disabled = false;
        btnKonfirmasi.style.opacity = "1";
        btnKonfirmasi.style.cursor = "pointer";
    }
}

function loadOrderData() {
    let data = localStorage.getItem('order_to_process');
    if(!data){
        Swal.fire({
            icon: 'warning',
            title: 'Tidak Ada Pesanan',
            text: 'Tidak ada pesanan yang diproses!',
            confirmButtonColor: '#e32222',
            confirmButtonText: 'Kembali ke Dashboard'
        }).then(() => {
            window.location.href = "<?php echo e(route('dashboard')); ?>";
        });
        return;
    }

    data = JSON.parse(data);
    orderDataGlobal = data;
    totalHargaGlobal = data.total_harga;

    document.getElementById('namaPelanggan').innerText = data.nama_pelanggan || data.id_pelanggan || 'Pelanggan';

    let tbody = document.getElementById('dataMenu');
    tbody.innerHTML = "";

    data.details.forEach(item => {
        let subtotal = item.harga * item.jumlah;

        tbody.innerHTML += `
            <tr>
                <td>${item.nama}</td>
                <td>Rp${formatRupiah(item.harga)}</td>
                <td>${item.jumlah}</td>
                <td style="color:red;">Rp${formatRupiah(subtotal)}</td>
            </tr>
        `;
    });

    document.getElementById('totalHarga').innerText = 'Rp' + formatRupiah(data.total_harga);
    
    // Disable konfirmasi sampai pilih metode
    let btnKonfirmasi = document.getElementById('btnKonfirmasi');
    btnKonfirmasi.disabled = true;
    btnKonfirmasi.style.opacity = '0.5';
    btnKonfirmasi.style.cursor = 'not-allowed';
}

function confirmQRISPayment() {
    stopQRISCountdown();
    processPayment(totalHargaGlobal, totalHargaGlobal, 0, 'QRIS');
}

function processPayment(total, bayar, kembalian, metode) {
    let riwayat = JSON.parse(localStorage.getItem('riwayat')) || [];

    riwayat.push({
        id: Date.now(),
        pelanggan: orderDataGlobal.nama_pelanggan || orderDataGlobal.id_pelanggan || 'Pelanggan',
        tipe_layanan: orderDataGlobal.tipe_layanan || 'Dine In',
        total: total,
        bayar: bayar,
        kembalian: kembalian,
        metode_pembayaran: metode,
        waktu: new Date().toLocaleString('id-ID'),
        details: orderDataGlobal.details
    });

    localStorage.setItem('riwayat', JSON.stringify(riwayat));
    
    sessionStorage.setItem('transaksi_terbaru', JSON.stringify({
        id: Date.now(),
        pelanggan: orderDataGlobal.nama_pelanggan || orderDataGlobal.id_pelanggan || 'Pelanggan',
        tipe_layanan: orderDataGlobal.tipe_layanan || 'Dine In',
        total: total,
        bayar: bayar,
        kembalian: kembalian,
        metode_pembayaran: metode,
        waktu: new Date().toLocaleString('id-ID'),
        details: orderDataGlobal.details
    }));
    
    localStorage.removeItem('order_to_process');

    let metodeIcon = '';
    switch(metode) {
        case 'Tunai': metodeIcon = '💵'; break;
        case 'QRIS': metodeIcon = '📱'; break;
        case 'Debit': metodeIcon = '💳'; break;
        case 'E-Wallet': metodeIcon = '📲'; break;
    }

    Swal.fire({
        icon: 'success',
        title: 'Pembayaran Berhasil!',
        html: `
            <div class="text-center">
                <p>${metodeIcon} Metode: <b>${metode}</b></p>
                <p>Total: <b>Rp${formatRupiah(total)}</b></p>
                <p>Bayar: <b>Rp${formatRupiah(bayar)}</b></p>
                <p>Kembalian: <b>Rp${formatRupiah(kembalian)}</b></p>
            </div>
        `,
        confirmButtonColor: '#28a745',
        confirmButtonText: 'Cetak Struk'
    }).then(() => {
        window.location.href = "<?php echo e(route('struk')); ?>";
    });
}

function konfirmasiPesanan() {
    let metode = document.getElementById('metodeBayar').value;
    
    if (!metode) {
        Swal.fire({
            icon: 'warning',
            title: 'Pilih Metode',
            text: 'Silakan pilih metode pembayaran terlebih dahulu!',
            confirmButtonColor: '#e32222'
        });
        return;
    }
    
    let total = totalHargaGlobal;
    
    if (metode === 'Tunai') {
        let bayar = parseInt(document.getElementById('pembayaran').value);
        
        if(!bayar || bayar < total){
            Swal.fire({
                icon: 'error',
                title: 'Pembayaran Kurang',
                text: 'Jumlah pembayaran tidak mencukupi total harga!',
                confirmButtonColor: '#e32222'
            });
            return;
        }
        
        let kembalian = bayar - total;
        processPayment(total, bayar, kembalian, 'Tunai');
        
    } else if (metode === 'QRIS') {
        // QRIS sudah ditampilkan, tinggal konfirmasi dari tombol di display QRIS
        // Jika tombol konfirmasi utama ditekan, ingatkan untuk scan dulu
        Swal.fire({
            icon: 'info',
            title: 'Scan QR Code',
            text: 'Silakan scan QR Code yang sudah ditampilkan menggunakan aplikasi pembayaran Anda, lalu klik tombol "Konfirmasi Setelah Scan"',
            confirmButtonColor: '#28a745'
        });
        
    } else if (metode === 'Debit') {
        Swal.fire({
            title: 'Konfirmasi Pembayaran Debit/Kredit',
            html: `
                <p>💳 Metode: <b>Debit / Kartu Kredit</b></p>
                <p>Total: <b>Rp${formatRupiah(total)}</b></p>
                <p>Silakan lakukan pembayaran menggunakan mesin EDC.</p>
                <p style="font-size:12px; color:#666;">Setelah pembayaran berhasil, klik tombol di bawah.</p>
            `,
            showCancelButton: true,
            confirmButtonText: '✅ Ya, Sudah Dibayar',
            cancelButtonText: '❌ Batal',
            confirmButtonColor: '#28a745'
        }).then((result) => {
            if (result.isConfirmed) {
                processPayment(total, total, 0, 'Debit');
            }
        });
        
    } else if (metode === 'E-Wallet') {
        Swal.fire({
            title: 'Konfirmasi Pembayaran E-Wallet',
            html: `
                <p>📲 Metode: <b>E-Wallet</b></p>
                <p>Total: <b>Rp${formatRupiah(total)}</b></p>
                <p>Silakan lakukan pembayaran melalui aplikasi E-Wallet (OVO/GoPay/DANA).</p>
                <p style="font-size:12px; color:#666;">Setelah pembayaran berhasil, klik tombol di bawah.</p>
            `,
            showCancelButton: true,
            confirmButtonText: '✅ Ya, Sudah Dibayar',
            cancelButtonText: '❌ Batal',
            confirmButtonColor: '#28a745'
        }).then((result) => {
            if (result.isConfirmed) {
                processPayment(total, total, 0, 'E-Wallet');
            }
        });
    }
}

// ===================== FUNGSI LOGOUT =====================
function logoutAndRedirect() {
    const alertDiv = document.getElementById('logoutAlert');
    alertDiv.style.display = 'block';
    
    sessionStorage.removeItem('transaksi_terbaru');
    localStorage.removeItem('transaksi_terbaru');
    sessionStorage.removeItem('lastOrder');
    localStorage.removeItem('lastOrder');
    localStorage.removeItem('order_to_process');
    localStorage.removeItem('admin_token');
    localStorage.removeItem('admin_logged_in');
    localStorage.removeItem('user_data');
    sessionStorage.removeItem('user_session');
    sessionStorage.removeItem('auth_token');
    localStorage.removeItem('kasir_login');
    sessionStorage.removeItem('kasir_session');
    localStorage.removeItem('isLoggedIn');
    sessionStorage.removeItem('isLoggedIn');
    
    setTimeout(function() {
        window.location.href = '/login';
    }, 800);
}

function confirmLogout(event) {
    if (event) event.preventDefault();
    
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Anda akan logout dari sistem dan kembali ke halaman login.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Logout',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            logoutAndRedirect();
        }
    });
}

window.onload = loadOrderData;
</script>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</body>
</html><?php /**PATH C:\xamppbaruu\htdocs\laravel\resources\views/pembayaran.blade.php ENDPATH**/ ?>