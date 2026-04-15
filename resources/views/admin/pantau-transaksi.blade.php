<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Riwayat Transaksi - Manajemen Penjualan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    background: #f8f9fa;
    font-family: 'Segoe UI', Arial, sans-serif;
}

/* SIDEBAR */
.sidebar {
    width: 220px;
    height: 100vh;
    background: #ff7a00;
    position: fixed;
    color: white;
    padding: 20px;
    transition: all 0.3s;
    z-index: 1000;
}

.sidebar h3 {
    font-weight: bold;
    margin-bottom: 30px;
    font-size: 1.5rem;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar li {
    margin-bottom: 10px;
}

.sidebar a {
    display: block;
    background: #e66a00;
    padding: 12px 15px;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    transition: 0.3s;
}

.sidebar a:hover {
    background: #cc5c00;
    transform: translateX(5px);
}

.sidebar a.active {
    background: #cc5c00;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

/* CONTENT */
.content {
    margin-left: 220px;
    padding: 30px;
}

/* CARD */
.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-2px);
}

/* TABLE */
.table {
    border-radius: 10px;
    overflow: hidden;
}

.table thead {
    background: #ff7a00;
    color: white;
}

.table th {
    text-align: center;
    vertical-align: middle;
    font-weight: 600;
}

.table td {
    vertical-align: middle;
}

.table tbody tr:hover {
    background: #fff3e6;
    cursor: pointer;
}

/* BUTTON */
.btn-detail {
    background: #ff7a00;
    color: white;
    border: none;
    padding: 5px 12px;
    border-radius: 6px;
    font-size: 12px;
    transition: 0.2s;
}

.btn-detail:hover {
    background: #cc5c00;
    transform: scale(1.05);
}

/* STAT */
.stat-card {
    border-radius: 12px;
    padding: 20px;
    color: white;
}

.card-primary {
    background: linear-gradient(135deg, #ff7a00, #ffb347);
}

.card-success {
    background: linear-gradient(135deg, #ff9a3c, #ffd27f);
}

.stat-card h3 {
    font-weight: bold;
    margin-bottom: 0;
}

/* FILTER SECTION */
.filter-section {
    background: white;
    border-radius: 12px;
    padding: 15px 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.filter-label {
    font-weight: 600;
    color: #ff7a00;
    margin-bottom: 5px;
}

/* MODAL DETAIL */
.modal-detail-item {
    border-left: 4px solid #ff7a00;
    padding: 10px 15px;
    background: #f8f9fa;
    margin-bottom: 10px;
    border-radius: 8px;
}

.modal-detail-item strong {
    color: #ff7a00;
}

/* EMPTY STATE */
.empty-state {
    text-align: center;
    padding: 50px;
    color: #999;
}

.empty-state i {
    font-size: 48px;
    margin-bottom: 15px;
    color: #ff7a00;
    opacity: 0.5;
}

/* RESET FILTER */
.btn-reset {
    background: #6c757d;
    color: white;
    border: none;
    padding: 5px 15px;
    border-radius: 6px;
    transition: 0.2s;
}

.btn-reset:hover {
    background: #5a6268;
}

/* BADGE */
.badge-cash {
    background: #28a745;
    color: white;
    padding: 3px 8px;
    border-radius: 20px;
    font-size: 11px;
}

/* PRODUK LIST */
.produk-list {
    max-height: 300px;
    overflow-y: auto;
}
</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h3><i class="bi bi-speedometer2"></i> Admin</h3>
    <ul>
        <li><a href="/admin/dashboard"><i class="bi bi-house"></i> Dashboard</a></li>
        <li><a href="/admin/produk"><i class="bi bi-box"></i> Kelola Produk</a></li>
        <li><a href="/kelola-akun-kasir"><i class="bi bi-people"></i> Kelola Kasir</a></li>
        <li><a href="/pantau-transaksi" class="active"><i class="bi bi-graph-up"></i> Pantau Transaksi</a></li>
        <li><a href="/log-activity"><i class="bi bi-clock-history"></i> Log Activity</a></li>
        <li><a href="/admin/laporan"><i class="bi bi-file-earmark-text"></i> Laporan</a></li>
    </ul>
</div>

<!-- CONTENT -->
<div class="content">

    <h2 class="mb-4" style="color:#ff7a00;">
        <i class="bi bi-clock-history"></i> Riwayat Transaksi
    </h2>

    <!-- STAT CARD -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="stat-card card-primary">
                <h5><i class="bi bi-receipt"></i> Total Transaksi</h5>
                <h3 id="totalTransaksi">0</h3>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stat-card card-success">
                <h5><i class="bi bi-cash-stack"></i> Total Pendapatan</h5>
                <h3 id="totalPendapatan">Rp0</h3>
            </div>
        </div>
    </div>

    <!-- FILTER SECTION - HANYA NO TRANSAKSI -->
    <div class="filter-section">
        <div class="row align-items-end">
            <div class="col-md-8">
                <div class="filter-label"><i class="bi bi-search"></i> Cari No Transaksi</div>
                <input type="text" id="searchNoTransaksi" class="form-control" placeholder="Cari berdasarkan No Transaksi... (contoh: TRX-001)">
            </div>
            <div class="col-md-4">
                <button class="btn-reset" id="resetFilterBtn" style="width: 100%;">
                    <i class="bi bi-arrow-repeat"></i> Reset Filter
                </button>
            </div>
        </div>
    </div>

    <!-- TABLE TRANSACTION -->
    <div class="card">
        <div class="card-header" style="background:#fff; border-bottom: 2px solid #ff7a00;">
            <strong style="color:#ff7a00;"><i class="bi bi-table"></i> Daftar Transaksi</strong>
            <span class="badge-cash float-end" id="totalFiltered">Menampilkan 0 data</span>
        </div>

        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Transaksi</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Bayar</th>
                        <th>Kembalian</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="dataRiwayat"></tbody>
            </table>
        </div>
    </div>

</div>

<!-- MODAL DETAIL TRANSACTION -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #ff7a00; color: white;">
                <h5 class="modal-title" id="detailModalLabel">
                    <i class="bi bi-receipt"></i> Detail Transaksi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalDetailBody">
                <!-- Konten detail akan diisi via JS -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-detail" id="printDetailBtn">
                    <i class="bi bi-printer"></i> Cetak
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
let allRiwayat = [];
let filteredData = [];

// Fungsi format Rupiah
function formatRupiah(angka){
    if(angka === undefined || angka === null) angka = 0;
    return 'Rp' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g,".");
}

// Fungsi untuk parse tanggal dari string "DD/MM/YYYY HH:MM:SS"
function parseTanggal(tanggalStr) {
    if (!tanggalStr) return new Date(0);
    let parts = tanggalStr.split(' ');
    let datePart = parts[0];
    let timePart = parts[1] || '00:00:00';
    let dateSplit = datePart.split('/');
    if(dateSplit.length === 3){
        let day = dateSplit[0];
        let month = dateSplit[1];
        let year = dateSplit[2];
        return new Date(`${year}-${month}-${day}T${timePart}`);
    }
    return new Date(tanggalStr);
}

// Load data dari localStorage
function loadRiwayat(){
    let stored = localStorage.getItem('riwayat');
    if(stored && JSON.parse(stored).length > 0){
        allRiwayat = JSON.parse(stored);
    } else {
        // Data dummy untuk demo jika kosong
        allRiwayat = generateDummyData();
        localStorage.setItem('riwayat', JSON.stringify(allRiwayat));
    }
    
    updateStats(allRiwayat);
    applyFilters();
}

// Generate dummy data dengan produk yang valid
function generateDummyData(){
    const dummy = [];
    const pelangganList = ['Budi Santoso', 'Siti Aminah', 'Ahmad Fauzi', 'Dewi Lestari', 'Rizky Pratama', 'Umum'];
    const daftarProduk = [
        { nama: "Indomie Goreng", harga: 3500 },
        { nama: "Indomie Kuah", harga: 3500 },
        { nama: "Teh Botol Sosro", harga: 5000 },
        { nama: "Aqua 600ml", harga: 3000 },
        { nama: "Roti Tawar", harga: 12000 },
        { nama: "Keju Cheddar", harga: 25000 },
        { nama: "Susu UHT", harga: 15000 },
        { nama: "Biskuit Roma", harga: 8000 },
        { nama: "Mie Sedap", harga: 3200 },
        { nama: "Kopi Kapal Api", harga: 2000 }
    ];
    
    const now = new Date();
    
    for(let i=1; i<=12; i++){
        let date = new Date(now);
        date.setDate(now.getDate() - (i * 2));
        let day = date.getDate().toString().padStart(2,'0');
        let month = (date.getMonth()+1).toString().padStart(2,'0');
        let year = date.getFullYear();
        let hour = (10 + i) % 24;
        let minute = i * 3 % 60;
        let waktuStr = `${day}/${month}/${year} ${hour.toString().padStart(2,'0')}:${minute.toString().padStart(2,'0')}:00`;
        
        // Generate items random (2-5 produk)
        let jumlahItem = Math.floor(Math.random() * 4) + 2; // 2-5 item
        let items = [];
        let total = 0;
        
        // Pilih produk acak tanpa duplikat
        let produkTerpilih = [...daftarProduk];
        for(let j = 0; j < jumlahItem && produkTerpilih.length > 0; j++){
            let randomIndex = Math.floor(Math.random() * produkTerpilih.length);
            let produk = produkTerpilih[randomIndex];
            let qty = Math.floor(Math.random() * 5) + 1; // 1-5 pcs
            let subtotal = produk.harga * qty;
            total += subtotal;
            
            items.push({
                nama: produk.nama,
                qty: qty,
                harga: produk.harga,
                subtotal: subtotal
            });
            
            // Hapus produk yang sudah dipilih agar tidak duplikat
            produkTerpilih.splice(randomIndex, 1);
        }
        
        // Bulatkan total ke ribuan terdekat
        total = Math.ceil(total / 1000) * 1000;
        
        // Adjust item terakhir agar total sesuai
        if(items.length > 0 && items[items.length-1]){
            let selisih = total - items.reduce((sum, item) => sum + item.subtotal, 0);
            items[items.length-1].subtotal += selisih;
            items[items.length-1].harga = Math.round(items[items.length-1].subtotal / items[items.length-1].qty);
        }
        
        let bayar = total + Math.floor(Math.random() * 50000);
        let kembalian = bayar - total;
        
        dummy.push({
            id: i.toString().padStart(3,'0'),
            pelanggan: pelangganList[Math.floor(Math.random() * pelangganList.length)],
            total: total,
            bayar: bayar,
            kembalian: kembalian,
            waktu: waktuStr,
            items: items,
            kasir: "Kasir " + (Math.floor(Math.random()*3)+1)
        });
    }
    // Urutkan dari yang terbaru
    dummy.sort((a,b) => {
        let dateA = parseTanggal(a.waktu);
        let dateB = parseTanggal(b.waktu);
        return dateB - dateA;
    });
    return dummy;
}

// Update statistik total transaksi & pendapatan
function updateStats(data){
    document.getElementById('totalTransaksi').innerText = data.length;
    let total = data.reduce((a,b)=>a+(b.total||0),0);
    document.getElementById('totalPendapatan').innerText = formatRupiah(total);
}

// Fungsi filter hanya berdasarkan No Transaksi
function applyFilters(){
    let searchNo = document.getElementById('searchNoTransaksi').value.toLowerCase().trim();
    
    let filtered = [...allRiwayat];
    
    if(searchNo){
        filtered = filtered.filter(trx => `TRX-${trx.id}`.toLowerCase().includes(searchNo));
    }
    
    filteredData = filtered;
    updateStats(filteredData);
    displayFilteredData(filteredData);
    document.getElementById('totalFiltered').innerHTML = `Menampilkan ${filteredData.length} data`;
}

// Menampilkan data yang sudah difilter
function displayFilteredData(data){
    let html = "";
    
    if(data.length === 0){
        html = `
            <tr>
                <td colspan="8" class="empty-state">
                    <i class="bi bi-inbox"></i><br>
                    Tidak ada transaksi yang sesuai
                </td>
            </tr>
        `;
    } else {
        data.forEach((item, index)=>{
            html += `
            <tr>
                <td class="text-center">${index+1}</td>
                <td><b><i class="bi bi-upc-scan"></i> TRX-${item.id}</b></td>
                <td><i class="bi bi-person-circle"></i> ${item.pelanggan || 'Umum'}</td>
                <td class="text-warning fw-bold">${formatRupiah(item.total)}</td>
                <td>${formatRupiah(item.bayar)}</td>
                <td class="text-success">${formatRupiah(item.kembalian)}</td>
                <td><small><i class="bi bi-clock"></i> ${item.waktu}</small></td>
                <td class="text-center">
                    <button class="btn-detail" onclick="showDetail('${item.id}')">
                        <i class="bi bi-eye"></i> Detail
                    </button>
                </td>
            </tr>
            `;
        });
    }
    
    document.getElementById('dataRiwayat').innerHTML = html;
}

// Fungsi show detail dengan modal (bukan alert)
function showDetail(transactionId){
    // Cari transaksi berdasarkan ID
    let transaction = allRiwayat.find(trx => trx.id == transactionId);
    
    if(!transaction){
        alert("Transaksi tidak ditemukan!");
        return;
    }
    
    console.log("Transaction items:", transaction.items); // Debugging
    
    // Membangun konten modal yang informatif
    let itemsHtml = '';
    if(transaction.items && transaction.items.length > 0){
        itemsHtml = '<div class="produk-list">';
        transaction.items.forEach((item, idx) => {
            itemsHtml += `
                <div class="modal-detail-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <strong>${idx+1}. ${item.nama}</strong>
                        </div>
                        <div class="col-3">
                            ${item.qty} x ${formatRupiah(item.harga)}
                        </div>
                        <div class="col-4 text-end text-primary fw-bold">
                            ${formatRupiah(item.subtotal)}
                        </div>
                    </div>
                </div>
            `;
        });
        itemsHtml += '</div>';
    } else {
        itemsHtml = `
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle"></i> 
                Tidak ada detail produk untuk transaksi ini. Data mungkin dalam format lama.
            </div>
        `;
    }
    
    let modalBody = `
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="border p-3 rounded bg-light">
                    <small class="text-muted text-uppercase">No. Transaksi</small>
                    <h5 class="text-primary mb-0">TRX-${transaction.id}</h5>
                </div>
            </div>
            <div class="col-md-6">
                <div class="border p-3 rounded bg-light">
                    <small class="text-muted text-uppercase">Waktu Transaksi</small>
                    <h5 class="mb-0"><i class="bi bi-calendar3"></i> ${transaction.waktu}</h5>
                </div>
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="border p-3 rounded bg-light">
                    <small class="text-muted text-uppercase">Pelanggan</small>
                    <h5 class="mb-0"><i class="bi bi-person"></i> ${transaction.pelanggan || 'Umum'}</h5>
                </div>
            </div>
            <div class="col-md-6">
                <div class="border p-3 rounded bg-light">
                    <small class="text-muted text-uppercase">Kasir</small>
                    <h5 class="mb-0"><i class="bi bi-person-badge"></i> ${transaction.kasir || 'Admin'}</h5>
                </div>
            </div>
        </div>
        
        <div class="card mt-2 mb-3">
            <div class="card-header bg-white" style="border-bottom: 2px solid #ff7a00;">
                <strong><i class="bi bi-cart3"></i> Detail Produk</strong>
                <span class="float-end">${transaction.items ? transaction.items.length : 0} item</span>
            </div>
            <div class="card-body p-2">
                ${itemsHtml}
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-4">
                <div class="p-3 text-center border rounded" style="background: #fff8f0;">
                    <small class="text-muted">Total Belanja</small>
                    <h4 class="text-warning mb-0">${formatRupiah(transaction.total)}</h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 text-center border rounded" style="background: #f0fff4;">
                    <small class="text-muted">Uang Bayar</small>
                    <h4 class="text-success mb-0">${formatRupiah(transaction.bayar)}</h4>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 text-center border rounded" style="background: #fff0f0;">
                    <small class="text-muted">Kembalian</small>
                    <h4 class="text-danger mb-0">${formatRupiah(transaction.kembalian)}</h4>
                </div>
            </div>
        </div>
        
        <div class="alert alert-info mt-3 mb-0">
            <i class="bi bi-check-circle-fill"></i> Status: <strong>LUNAS</strong> | Metode Pembayaran: Tunai
        </div>
    `;
    
    document.getElementById('modalDetailBody').innerHTML = modalBody;
    
    // Simpan data transaksi untuk cetak
    window.currentPrintTransaction = transaction;
    
    // Tampilkan modal
    let modal = new bootstrap.Modal(document.getElementById('detailModal'));
    modal.show();
}

// Event listener untuk cetak detail
document.getElementById('printDetailBtn').addEventListener('click', function(){
    if(window.currentPrintTransaction){
        let trx = window.currentPrintTransaction;
        let printWindow = window.open('', '_blank');
        let itemsPrint = '';
        if(trx.items && trx.items.length > 0){
            trx.items.forEach(item => {
                itemsPrint += `
                    <tr>
                        <td>${item.nama}</td>
                        <td style="text-align:center">${item.qty}</td>
                        <td style="text-align:right">${formatRupiah(item.harga)}</td>
                        <td style="text-align:right">${formatRupiah(item.subtotal)}</td>
                    </tr>
                `;
            });
        } else {
            itemsPrint = '<tr><td colspan="4" style="text-align:center">Tidak ada data produk</td></tr>';
        }
        
        printWindow.document.write(`
            <html>
            <head>
                <title>Cetak Struk TRX-${trx.id}</title>
                <style>
                    body { font-family: 'Courier New', monospace; padding: 20px; max-width: 400px; margin: 0 auto; }
                    .header { text-align: center; border-bottom: 1px dashed #000; margin-bottom: 20px; padding-bottom: 10px; }
                    .total { margin-top: 20px; border-top: 1px dashed #000; padding-top: 10px; }
                    table { width: 100%; border-collapse: collapse; }
                    th, td { padding: 5px; text-align: left; }
                    .text-right { text-align: right; }
                    .text-center { text-align: center; }
                    .footer { margin-top: 20px; text-align: center; font-size: 12px; }
                    hr { border-top: 1px dashed #000; }
                </style>
            </head>
            <body>
                <div class="header">
                    <h3>TOKO ADMIN</h3>
                    <p>${trx.waktu}</p>
                    <p><strong>No. TRX-${trx.id}</strong></p>
                    <p>Kasir: ${trx.kasir || 'Admin'}</p>
                </div>
                <p><strong>Pelanggan:</strong> ${trx.pelanggan || 'Umum'}</p>
                <hr>
                <table>
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Harga</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${itemsPrint}
                    </tbody>
                </table>
                <div class="total">
                    <p><strong>Total: ${formatRupiah(trx.total)}</strong></p>
                    <p>Bayar: ${formatRupiah(trx.bayar)}</p>
                    <p>Kembalian: ${formatRupiah(trx.kembalian)}</p>
                </div>
                <div class="footer">
                    <p>Terima kasih telah berbelanja!</p>
                    <p>Barang yang sudah dibeli tidak dapat dikembalikan</p>
                </div>
            </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    } else {
        alert("Tidak ada data untuk dicetak");
    }
});

// Reset semua filter
function resetFilters(){
    document.getElementById('searchNoTransaksi').value = '';
    applyFilters();
}

// Event listeners untuk filter
document.getElementById('searchNoTransaksi').addEventListener('keyup', applyFilters);
document.getElementById('resetFilterBtn').addEventListener('click', resetFilters);

// Inisialisasi saat halaman dimuat
window.onload = function() {
    loadRiwayat();
};
</script>

</body>
</html>