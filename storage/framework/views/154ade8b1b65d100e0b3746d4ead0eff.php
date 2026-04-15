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
    <a href="<?php echo e(route('riwayat')); ?>">
        <i class="bi bi-clock-history"></i> Riwayat
    </a>

    <div class="menu-spacer"></div>

    <!-- TOMBOL LOGOUT DI SIDEBAR -->
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

    <!-- INPUT BAYAR -->
    <div class="mt-3">
        <label for="pembayaran" class="form-label"><strong>Jumlah Pembayaran</strong></label>
        <input type="number" id="pembayaran" class="form-control" style="width:300px;" placeholder="Masukkan jumlah pembayaran" oninput="hitungKembalian()">
    </div>

    <!-- BOX KEMBALIAN -->
    <div class="kembalian-box" id="kembalianBox" style="display: none;">
        <div class="label">Kembalian</div>
        <div class="value" id="kembalianValue">Rp0</div>
        <div class="info-text" id="infoKembalian"></div>
    </div>

    <!-- BUTTON -->
    <button class="btn btn-konfirmasi mt-3" onclick="konfirmasiPesanan()" id="btnKonfirmasi">Konfirmasi Pembayaran</button>

</div>

<!-- Alert notifikasi -->
<div id="logoutAlert" class="logout-alert">
    ✅ Logout berhasil! Mengalihkan ke halaman login...
</div>

<script>
let orderDataGlobal = null;
let totalHargaGlobal = 0;

function formatRupiah(angka){
    if (angka === undefined || angka === null) return '0';
    return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g,".");
}

function hitungKembalian() {
    let bayar = parseInt(document.getElementById('pembayaran').value);
    let total = totalHargaGlobal;
    let kembalianBox = document.getElementById('kembalianBox');
    let kembalianValue = document.getElementById('kembalianValue');
    let infoKembalian = document.getElementById('infoKembalian');
    let btnKonfirmasi = document.getElementById('btnKonfirmasi');
    
    // Jika input kosong atau bukan angka
    if (isNaN(bayar) || bayar === "") {
        kembalianBox.style.display = "none";
        btnKonfirmasi.disabled = false;
        btnKonfirmasi.style.opacity = "1";
        btnKonfirmasi.style.cursor = "pointer";
        return;
    }
    
    let kembalian = bayar - total;
    
    if (bayar < total) {
        // Pembayaran kurang
        kembalianValue.innerHTML = `Rp${formatRupiah(Math.abs(kembalian))}`;
        kembalianValue.className = "value kurang";
        infoKembalian.innerHTML = "⚠️ Pembayaran masih kurang! Silakan tambah nominal.";
        kembalianBox.style.display = "block";
        btnKonfirmasi.disabled = true;
        btnKonfirmasi.style.opacity = "0.5";
        btnKonfirmasi.style.cursor = "not-allowed";
    } else {
        // Pembayaran cukup atau lebih
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

function loadOrderData(){
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
}

function konfirmasiPesanan(){
    let total = totalHargaGlobal;
    let bayar = parseInt(document.getElementById('pembayaran').value);

    if(!bayar || bayar < total){
        Swal.fire({
            icon: 'error',
            title: 'Pembayaran Kurang',
            text: 'Jumlah pembayaran tidak mencukupi total harga!',
            confirmButtonColor: '#e32222',
            confirmButtonText: 'OK'
        });
        return;
    }

    let kembalian = bayar - total;
    
    // Simpan ke riwayat dengan format yang benar
    let riwayat = JSON.parse(localStorage.getItem('riwayat')) || [];

    riwayat.push({
        id: Date.now(),
        pelanggan: orderDataGlobal.nama_pelanggan || orderDataGlobal.id_pelanggan || 'Pelanggan',
        tipe_layanan: orderDataGlobal.tipe_layanan || 'Dine In',
        total: total,
        bayar: bayar,
        kembalian: kembalian,
        waktu: new Date().toLocaleString('id-ID'),
        details: orderDataGlobal.details
    });

    localStorage.setItem('riwayat', JSON.stringify(riwayat));
    
    // Simpan untuk struk
    sessionStorage.setItem('transaksi_terbaru', JSON.stringify({
        id: Date.now(),
        pelanggan: orderDataGlobal.nama_pelanggan || orderDataGlobal.id_pelanggan || 'Pelanggan',
        tipe_layanan: orderDataGlobal.tipe_layanan || 'Dine In',
        total: total,
        bayar: bayar,
        kembalian: kembalian,
        waktu: new Date().toLocaleString('id-ID'),
        details: orderDataGlobal.details
    }));
    
    localStorage.removeItem('order_to_process');

    Swal.fire({
        icon: 'success',
        title: 'Pembayaran Berhasil!',
        html: `
            <div class="text-center">
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

// ===================== FUNGSI LOGOUT =====================
function logoutAndRedirect() {
    // Tampilkan alert notifikasi
    const alertDiv = document.getElementById('logoutAlert');
    alertDiv.style.display = 'block';
    
    // Hapus semua data session dan auth
    sessionStorage.removeItem('transaksi_terbaru');
    localStorage.removeItem('transaksi_terbaru');
    sessionStorage.removeItem('lastOrder');
    localStorage.removeItem('lastOrder');
    localStorage.removeItem('order_to_process');
    
    // Hapus data login/admin/auth
    localStorage.removeItem('admin_token');
    localStorage.removeItem('admin_logged_in');
    localStorage.removeItem('user_data');
    sessionStorage.removeItem('user_session');
    sessionStorage.removeItem('auth_token');
    localStorage.removeItem('kasir_login');
    sessionStorage.removeItem('kasir_session');
    localStorage.removeItem('isLoggedIn');
    sessionStorage.removeItem('isLoggedIn');
    
    // Redirect ke halaman LOGIN
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
        cancelButtonText: 'Batal',
        background: '#fff',
        customClass: {
            popup: 'rounded-lg'
        }
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
</html><?php /**PATH C:\xamppbaruu\htdocs\laravel\resources\views/kasir.blade.php ENDPATH**/ ?>