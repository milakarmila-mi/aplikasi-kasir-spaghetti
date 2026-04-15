<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Struk Pembayaran - Spaghetteria</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background: #f3f3f3;
    font-family: 'Courier New', monospace;
    margin: 0;
    padding: 20px;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.struk-container {
    max-width: 400px;
    margin: 0 auto;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    position: relative;
}

.struk-header {
    text-align: center;
    border-bottom: 2px dashed #ddd;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

.struk-header h3 {
    color: #e32222;
    margin-bottom: 5px;
    font-weight: bold;
}

.struk-header p {
    margin: 0;
    font-size: 12px;
    color: #666;
}

.struk-detail {
    margin-bottom: 20px;
}

.struk-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
    font-size: 14px;
}

.struk-total {
    border-top: 2px dashed #ddd;
    border-bottom: 2px dashed #ddd;
    padding: 10px 0;
    margin: 10px 0;
    font-weight: bold;
}

.struk-pembayaran {
    margin: 15px 0;
}

.btn-cetak {
    background: #28a745;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
    margin-top: 20px;
    font-weight: bold;
    transition: all 0.2s;
}

.btn-cetak:hover {
    background: #218838;
    transform: scale(0.98);
}

.btn-kembali {
    background: #dc3545;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
    margin-top: 10px;
    font-weight: bold;
    transition: all 0.2s;
}

.btn-kembali:hover {
    background: #c82333;
    transform: scale(0.98);
}

.btn-home {
    background: #6c757d;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
    margin-top: 10px;
    font-weight: bold;
    transition: all 0.2s;
}

.btn-home:hover {
    background: #5a6268;
    transform: scale(0.98);
}

.text-right {
    text-align: right;
}

.text-center {
    text-align: center;
}

hr {
    border: none;
    border-top: 1px dashed #ddd;
}

/* Styling untuk print */
@media print {
    body {
        background: white;
        padding: 0;
        margin: 0;
    }
    .struk-container {
        box-shadow: none;
        padding: 10px;
        max-width: 100%;
    }
    .btn-cetak, .btn-kembali, .btn-home {
        display: none;
    }
}

/* Alert styling */
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

/* Tambahan dekorasi */
.struk-container::before {
    content: "🍝";
    position: absolute;
    top: -15px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 30px;
    background: white;
    padding: 0 10px;
}

/* Footer tambahan */
.struk-footer {
    margin-top: 20px;
    text-align: center;
    font-size: 11px;
    color: #999;
    border-top: 1px dashed #eee;
    padding-top: 15px;
}
</style>
</head>
<body>

<div class="struk-container" id="strukContainer">
    <div class="struk-header">
        <h3>🍝 NOTA PEMBAYARAN</h3>
        <p>Spaghetteria Restaurant</p>
        <p>Jl. Kuliner No. 45, Jakarta</p>
        <p>Telp: (021) 9876-5432</p>
        <hr>
        <p id="waktuTransaksi"></p>
    </div>

    <div class="struk-detail">
        <div class="struk-item">
            <span><strong>Pelanggan:</strong></span>
            <span id="namaPelangganStruk"></span>
        </div>
        <hr>
        <div id="detailMenuStruk"></div>
        <hr>
        <div class="struk-total">
            <div class="struk-item">
                <span><strong>TOTAL</strong></span>
                <span><strong id="totalStruk"></strong></span>
            </div>
        </div>
        <div class="struk-pembayaran">
            <div class="struk-item">
                <span>Pembayaran:</span>
                <span id="pembayaranStruk"></span>
            </div>
            <div class="struk-item">
                <span>Kembalian:</span>
                <span id="kembalianStruk" style="color: green; font-weight: bold;"></span>
            </div>
        </div>
    </div>

    <div class="text-center">
        <hr>
        <p style="font-size: 12px;">✨ Terima kasih atas kunjungan Anda ✨</p>
        <p style="font-size: 12px;">⭐ Simpan struk ini sebagai bukti pembayaran ⭐</p>
        <p style="font-size: 10px; color: #888;">#Spaghetteria #PastaEnak</p>
    </div>

    <button class="btn-cetak" onclick="cetakStruk()">🖨️ Cetak Struk</button>
</div>

<!-- Alert notifikasi -->
<div id="logoutAlert" class="logout-alert">
    ✅ Logout berhasil! Mengalihkan ke halaman login...
</div>

<script>
// Format Rupiah
function formatRupiah(angka){
    if (angka === undefined || angka === null) return 'Rp0';
    return 'Rp' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g,".");
}

// Fungsi kembali ke dashboard
function kembaliKeDashboard() {
    window.location.href = "<?php echo e(route('dashboard')); ?>";
}

// Fungsi logout lengkap
function logoutAndRedirect() {
    // Tampilkan alert notifikasi
    const alertDiv = document.getElementById('logoutAlert');
    alertDiv.style.display = 'block';
    
    // Hapus semua data session dan auth
    // 1. Hapus data transaksi terbaru
    sessionStorage.removeItem('transaksi_terbaru');
    localStorage.removeItem('transaksi_terbaru');
    
    // 2. Hapus data login/admin/auth (jika ada)
    localStorage.removeItem('admin_token');
    localStorage.removeItem('admin_logged_in');
    localStorage.removeItem('user_data');
    sessionStorage.removeItem('user_session');
    sessionStorage.removeItem('auth_token');
    
    // 3. Redirect ke halaman login setelah delay sebentar
    setTimeout(function() {
        window.location.href = '/login';
    }, 800);
}

// Fungsi logout dengan konfirmasi
function confirmLogout() {
    if (confirm('Apakah Anda yakin ingin logout?\nAnda akan dikembalikan ke halaman login.')) {
        logoutAndRedirect();
    }
}

// Load data struk
function loadStruk() {
    console.log('Mengambil data transaksi...');
    
    // Coba ambil dari sessionStorage dulu
    let transaksi = sessionStorage.getItem('transaksi_terbaru');
    
    // Jika tidak ada di sessionStorage, coba dari localStorage
    if (!transaksi) {
        console.log('Tidak ada di sessionStorage, coba dari localStorage');
        transaksi = localStorage.getItem('transaksi_terbaru');
    }
    
    // Jika masih tidak ada, coba dari URL parameter (alternatif)
    if (!transaksi) {
        const urlParams = new URLSearchParams(window.location.search);
        const transaksiParam = urlParams.get('data');
        if (transaksiParam) {
            try {
                transaksi = decodeURIComponent(transaksiParam);
                console.log('Data dari URL parameter');
            } catch(e) {
                console.log('Gagal decode URL parameter');
            }
        }
    }
    
    console.log('Data transaksi:', transaksi);
    
    if (!transaksi) {
        console.log('TIDAK ADA DATA TRANSASKI!');
        alert('⚠️ Tidak ada data transaksi!\nPastikan Anda sudah melakukan pembayaran terlebih dahulu.');
        // Redirect ke dashboard dengan parameter error
        window.location.href = "<?php echo e(route('dashboard')); ?>?error=no_transaction";
        return;
    }
    
    try {
        transaksi = JSON.parse(transaksi);
        console.log('Data berhasil diparse:', transaksi);
        
        // Tampilkan waktu transaksi
        const waktuElement = document.getElementById('waktuTransaksi');
        if (transaksi.waktu) {
            waktuElement.innerHTML = '<small>🕐 ' + transaksi.waktu + '</small>';
        } else {
            const now = new Date();
            const formattedTime = now.toLocaleString('id-ID', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            waktuElement.innerHTML = '<small>🕐 ' + formattedTime + '</small>';
        }
        
        // Tampilkan nama pelanggan
        document.getElementById('namaPelangganStruk').innerText = transaksi.pelanggan || 'Walk-in Customer';
        
        // Tampilkan detail menu
        let detailMenu = '';
        if (transaksi.details && transaksi.details.length > 0) {
            transaksi.details.forEach((item, index) => {
                let subtotal = (item.harga || 0) * (item.jumlah || 0);
                detailMenu += `
                    <div class="struk-item">
                        <span>${item.nama || 'Menu-' + (index+1)} x ${item.jumlah || 0}</span>
                        <span>${formatRupiah(subtotal)}</span>
                    </div>
                `;
            });
        } else {
            detailMenu = '<div class="struk-item"><span colspan="2">Tidak ada detail menu</span></div>';
        }
        document.getElementById('detailMenuStruk').innerHTML = detailMenu;
        
        // Tampilkan total, pembayaran, kembalian
        document.getElementById('totalStruk').innerHTML = formatRupiah(transaksi.total || 0);
        document.getElementById('pembayaranStruk').innerHTML = formatRupiah(transaksi.bayar || 0);
        document.getElementById('kembalianStruk').innerHTML = formatRupiah(transaksi.kembalian || 0);
        
    } catch (e) {
        console.error('Error parsing data:', e);
        alert('❌ Error membaca data transaksi\nDetail: ' + e.message);
        window.location.href = "<?php echo e(route('dashboard')); ?>";
    }
}

function cetakStruk() {
    window.print();
}

// Event listener untuk tombol logout
document.addEventListener('DOMContentLoaded', function() {
    // Load data struk
    loadStruk();
    
    // Setup tombol logout
    const btnLogout = document.getElementById('btnKembaliLogout');
    if (btnLogout) {
        btnLogout.addEventListener('click', function(e) {
            e.preventDefault();
            confirmLogout();
        });
    }
    
    // Optional: jika ada parameter logout di URL, langsung logout
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('logout') === '1') {
        logoutAndRedirect();
    }
});

// Handle jika pengguna menekan tombol back browser, tetap bisa logout
window.addEventListener('pageshow', function(event) {
    // Jika halaman di-restore dari bfcache, cek apakah perlu logout
    if (event.persisted) {
        console.log('Page restored from bfcache');
    }
});

// Tambahkan juga event untuk mencegah akses tanpa login (jika diperlukan)
function checkAuth() {
    // Cek apakah ada token login
    const isLoggedIn = localStorage.getItem('admin_logged_in') || sessionStorage.getItem('user_session');
    // Jika tidak ada data login dan bukan di halaman login, redirect ke login
    // Tapi karena ini halaman struk, biasanya datang setelah transaksi, jadi tidak perlu strict
    // Namun jika ingin lebih aman, uncomment kode di bawah:
    /*
    if (!isLoggedIn && window.location.pathname !== '/login' && !window.location.pathname.includes('struk')) {
        console.log('Tidak ada session login, redirect ke login');
        window.location.href = '/login';
    }
    */
}

// Panggil check auth
checkAuth();
</script>


<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</body>
</html><?php /**PATH C:\xamppbaruu\htdocs\laravel\resources\views/struk_cetak.blade.php ENDPATH**/ ?>