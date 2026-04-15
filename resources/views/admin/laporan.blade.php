<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Laporan - Spaghetteria</title>

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
.sidebar{
    width:230px;
    background:#ea580c;
    color:white;
    min-height:100vh;
    padding:20px;
    display: flex;
    flex-direction: column;
}
.sidebar a{
    color:white;
    display:block;
    padding:10px;
    border-radius:6px;
    margin-bottom:8px;
    text-decoration: none;
}
.sidebar a:hover{
    background:#c2410c;
}
.sidebar a.active{
    background:#c2410c;
}
/* Menu container - semua menu di atas */
.menu-container {
    flex: 1;
}
/* Logout container - di bawah menu, sesudah laporan */
.logout-container {
    margin-top: 20px;
    border-top: 1px solid rgba(255,255,255,0.2);
    padding-top: 16px;
}
.logout-container a {
    background: rgba(0,0,0,0.2);
    transition: all 0.2s ease;
}
.logout-container a:hover {
    background: #b91c1c;
}
.filter-active {
    background-color: #ea580c;
    color: white !important;
}
</style>
</head>

<body class="bg-gray-100">

<div class="flex">

<!-- SIDEBAR -->
<div class="sidebar">

<div class="menu-container">
    <h4 class="mb-6 text-xl font-bold">
        <i class="bi bi-speedometer2"></i> Admin Spaghetti
    </h4>

    <ul>
        <li><a href="/admin/dashboard"><i class="bi bi-house"></i> Dashboard</a></li>
        <li><a href="/admin/produk"><i class="bi bi-box"></i> Kelola Produk</a></li>
        <li><a href="/kelola-akun-kasir"><i class="bi bi-people"></i> Kelola Kasir</a></li>
        <li><a href="/pantau-transaksi"><i class="bi bi-graph-up"></i> Pantau Transaksi</a></li>
        <li><a href="/log-activity"><i class="bi bi-clock-history"></i> Log Activity</a></li>
        <li><a href="/admin/laporan" class="bg-orange-700"><i class="bi bi-file-earmark-text"></i> Laporan</a></li>
    </ul>
</div>

<!-- LOGOUT SESUDAH MENU LAPORAN (DI SIDEBAR) -->
<div class="logout-container">
    <a href="#" id="logoutButton" class="flex items-center gap-2">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>
</div>

</div>

<!-- CONTENT -->
<div class="flex-1 p-8">

<h1 class="text-3xl font-bold mb-6">Laporan Penjualan</h1>

<!-- FILTER -->
<div class="bg-white p-4 rounded shadow mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div>
            <label class="block text-sm text-gray-600 mb-1">Dari Tanggal</label>
            <input type="date" id="startDate" class="border p-2 rounded w-full">
        </div>
        <div>
            <label class="block text-sm text-gray-600 mb-1">Sampai Tanggal</label>
            <input type="date" id="endDate" class="border p-2 rounded w-full">
        </div>
        <div>
            <button onclick="filterLaporan()" class="bg-orange-500 text-white px-6 py-2 rounded w-full">
                <i class="bi bi-funnel"></i> Filter
            </button>
        </div>
        <div>
            <button onclick="resetFilter()" class="bg-gray-500 text-white px-6 py-2 rounded w-full">
                <i class="bi bi-arrow-repeat"></i> Reset
            </button>
        </div>
    </div>
    <div id="filterInfo" class="mt-3 text-sm text-gray-500"></div>
</div>

<!-- RINGKASAN -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white p-6 rounded shadow text-center">
        <i class="bi bi-receipt text-3xl text-orange-500 mb-2 block"></i>
        <p class="text-gray-500">Total Transaksi</p>
        <p class="text-2xl font-bold" id="totalTransaksi">0</p>
    </div>
    <div class="bg-white p-6 rounded shadow text-center">
        <i class="bi bi-currency-dollar text-3xl text-green-500 mb-2 block"></i>
        <p class="text-gray-500">Total Pendapatan</p>
        <p class="text-2xl font-bold text-green-600" id="totalPendapatan">Rp 0</p>
    </div>
    <div class="bg-white p-6 rounded shadow text-center">
        <i class="bi bi-box-seam text-3xl text-blue-500 mb-2 block"></i>
        <p class="text-gray-500">Total Item Terjual</p>
        <p class="text-2xl font-bold" id="totalItemTerjual">0</p>
    </div>
</div>

<!-- TABEL LAPORAN -->
<div class="bg-white rounded shadow overflow-hidden mb-6">
    <div class="bg-orange-500 text-white px-6 py-3 flex justify-between items-center">
        <h2 class="text-xl font-bold"><i class="bi bi-table"></i> Detail Transaksi</h2>
        <span id="recordCount" class="text-sm bg-white text-orange-600 px-3 py-1 rounded-full">0 record</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-orange-500 text-white">
                <tr>
                    <th class="p-3 text-left">Tanggal</th>
                    <th class="p-3 text-left">No. Transaksi</th>
                    <th class="p-3 text-left">Pelanggan</th>
                    <th class="p-3 text-left">Total Item</th>
                    <th class="p-3 text-left">Pendapatan</th>
                    <th class="p-3 text-left">Kasir</th>
                </tr>
            </thead>
            <tbody id="laporanTableBody">
                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-500">
                        <i class="bi bi-inbox text-4xl block mb-2"></i>
                        Belum ada data transaksi
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- GRAFIK BULANAN -->
<div class="bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4"><i class="bi bi-graph-up"></i> Grafik Penjualan Bulanan</h2>
    <canvas id="chartLaporan" style="max-height: 400px;"></canvas>
</div>

<!-- TABEL PRODUK TERLARIS -->
<div class="bg-white rounded shadow overflow-hidden mt-6">
    <div class="bg-orange-500 text-white px-6 py-3">
        <h2 class="text-xl font-bold"><i class="bi bi-trophy"></i> Produk Terlaris</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-orange-500 text-white">
                <tr>
                    <th class="p-3 text-left">Rank</th>
                    <th class="p-3 text-left">Nama Produk</th>
                    <th class="p-3 text-left">Total Terjual</th>
                    <th class="p-3 text-left">Total Pendapatan</th>
                </tr>
            </thead>
            <tbody id="topProductsBody">
                <tr>
                    <td colspan="4" class="p-8 text-center text-gray-500">
                        <i class="bi bi-inbox text-4xl block mb-2"></i>
                        Belum ada data produk
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

</div>

</div>

<script>
let chartInstance = null;
let allTransaksiData = [];

function formatRupiah(angka) {
    if (!angka && angka !== 0) return '0';
    return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// PERBAIKAN: Ekstrak tanggal dari format DD/MM/YYYY ke YYYY-MM-DD
function extractDateFromDDMMYYYY(tanggalStr) {
    if (!tanggalStr) return null;
    
    // Pisahkan tanggal dan waktu
    let datePart = tanggalStr.split(' ')[0];
    let parts = datePart.split('/');
    
    if (parts.length === 3) {
        let day = parts[0].padStart(2, '0');
        let month = parts[1].padStart(2, '0');
        let year = parts[2];
        return `${year}-${month}-${day}`;
    }
    
    return null;
}

// Parse tanggal lengkap untuk sorting
function parseTanggal(tanggalStr) {
    if (!tanggalStr) return new Date(0);
    
    if (tanggalStr.includes('/')) {
        let parts = tanggalStr.split(' ');
        let datePart = parts[0];
        let timePart = parts[1] || '00:00:00';
        let dateSplit = datePart.split('/');
        if(dateSplit.length === 3){
            let day = parseInt(dateSplit[0], 10);
            let month = parseInt(dateSplit[1], 10) - 1;
            let year = parseInt(dateSplit[2], 10);
            let timeSplit = timePart.split(':');
            let hour = parseInt(timeSplit[0], 10) || 0;
            let minute = parseInt(timeSplit[1], 10) || 0;
            let second = parseInt(timeSplit[2], 10) || 0;
            
            return new Date(year, month, day, hour, minute, second);
        }
    }
    
    return new Date(tanggalStr);
}

function formatTanggalOnly(tanggalStr) {
    if (!tanggalStr) return '-';
    let date = parseTanggal(tanggalStr);
    if (isNaN(date.getTime())) return tanggalStr.split(' ')[0];
    return date.toLocaleDateString('id-ID', { 
        day: '2-digit', 
        month: '2-digit', 
        year: 'numeric'
    });
}

function loadData() {
    const data = JSON.parse(localStorage.getItem('riwayat')) || [];
    
    // Transform data
    allTransaksiData = data.map(trx => {
        let totalItem = 0;
        let itemsList = [];
        
        if (trx.items && trx.items.length > 0) {
            trx.items.forEach(item => {
                totalItem += (item.qty || 0);
                itemsList.push({
                    nama: item.nama,
                    jumlah: item.qty || 0,
                    harga: item.harga || 0,
                    subtotal: item.subtotal || (item.harga * item.qty)
                });
            });
        }
        
        // Ekstrak tanggal dalam format YYYY-MM-DD untuk filter
        let tanggalFilter = extractDateFromDDMMYYYY(trx.waktu);
        
        return {
            id: trx.id,
            no_transaksi: `TRX-${trx.id}`,
            waktu: trx.waktu,
            tanggalFilter: tanggalFilter,
            pelanggan: trx.pelanggan || 'Umum',
            total_harga: trx.total || 0,
            bayar: trx.bayar || 0,
            kembalian: trx.kembalian || 0,
            total_item: totalItem,
            items: itemsList,
            kasir: trx.kasir || 'Admin'
        };
    });
    
    // Filter data yang memiliki tanggal valid
    allTransaksiData = allTransaksiData.filter(item => item.tanggalFilter !== null);
    
    // Urutkan dari yang terbaru
    allTransaksiData.sort((a, b) => parseTanggal(b.waktu) - parseTanggal(a.waktu));
    
    console.log('Data loaded:', allTransaksiData.length, 'transactions');
    
    return allTransaksiData;
}

// Filter data berdasarkan tanggal
function filterDataByDate(data, startDate, endDate) {
    if (!startDate && !endDate) {
        return data;
    }
    
    let filtered = [...data];
    
    if (startDate) {
        filtered = filtered.filter(item => {
            return item.tanggalFilter >= startDate;
        });
        console.log(`Filter >= ${startDate}: ${filtered.length} data tersisa`);
    }
    
    if (endDate) {
        filtered = filtered.filter(item => {
            return item.tanggalFilter <= endDate;
        });
        console.log(`Filter <= ${endDate}: ${filtered.length} data tersisa`);
    }
    
    return filtered;
}

// Hitung ringkasan statistik
function calculateStats(data) {
    const totalTransaksi = data.length;
    const totalPendapatan = data.reduce((sum, item) => sum + (item.total_harga || 0), 0);
    const totalItemTerjual = data.reduce((sum, item) => sum + (item.total_item || 0), 0);
    
    return { totalTransaksi, totalPendapatan, totalItemTerjual };
}

// Hitung top produk terlaris
function getTopProducts(data) {
    const productSales = new Map();
    
    data.forEach(trx => {
        if (trx.items && trx.items.length > 0) {
            trx.items.forEach(item => {
                if (productSales.has(item.nama)) {
                    const existing = productSales.get(item.nama);
                    existing.terjual += item.jumlah;
                    existing.pendapatan += item.subtotal;
                } else {
                    productSales.set(item.nama, {
                        nama: item.nama,
                        terjual: item.jumlah,
                        pendapatan: item.subtotal
                    });
                }
            });
        }
    });
    
    const sorted = Array.from(productSales.values()).sort((a, b) => b.terjual - a.terjual);
    return sorted.slice(0, 10);
}

// Update tabel laporan
function updateTable(filteredData) {
    const tbody = document.getElementById('laporanTableBody');
    const recordCount = document.getElementById('recordCount');
    
    recordCount.innerText = `${filteredData.length} record`;
    
    if (filteredData.length === 0) {
        tbody.innerHTML = `<tr><td colspan="6" class="p-8 text-center text-gray-500">
            <i class="bi bi-inbox text-4xl block mb-2"></i>
            Tidak ada data untuk periode yang dipilih
        <\/td><\/tr>`;
        return;
    }
    
    tbody.innerHTML = '';
    
    filteredData.forEach((item, index) => {
        tbody.innerHTML += `
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3 whitespace-nowrap">${formatTanggalOnly(item.waktu)}<\/td>
                <td class="p-3 font-mono text-sm">${item.no_transaksi}<\/td>
                <td class="p-3">${item.pelanggan}<\/td>
                <td class="p-3 text-center">${item.total_item} item<\/td>
                <td class="p-3 font-semibold text-green-600">${formatRupiah(item.total_harga)}<\/td>
                <td class="p-3">${item.kasir}<\/td>
              </tr>
        `;
    });
}

// Update tabel produk terlaris
function updateTopProductsTable(filteredData) {
    const tbody = document.getElementById('topProductsBody');
    const topProducts = getTopProducts(filteredData);
    
    if (topProducts.length === 0) {
        tbody.innerHTML = `<tr><td colspan="4" class="p-8 text-center text-gray-500">
            <i class="bi bi-inbox text-4xl block mb-2"></i>
            Belum ada data produk
        <\/td><\/tr>`;
        return;
    }
    
    tbody.innerHTML = '';
    topProducts.forEach((product, index) => {
        tbody.innerHTML += `
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3 text-center font-bold">
                    ${index === 0 ? '🥇' : index === 1 ? '🥈' : index === 2 ? '🥉' : `${index+1}.`}
                <\/td>
                <td class="p-3">${product.nama}<\/td>
                <td class="p-3 text-center font-semibold text-orange-600">${product.terjual} pcs<\/td>
                <td class="p-3 font-semibold text-green-600">${formatRupiah(product.pendapatan)}<\/td>
              </tr>
        `;
    });
}

// Update ringkasan statistik
function updateStats(filteredData) {
    const stats = calculateStats(filteredData);
    document.getElementById('totalTransaksi').innerText = stats.totalTransaksi;
    document.getElementById('totalPendapatan').innerText = formatRupiah(stats.totalPendapatan);
    document.getElementById('totalItemTerjual').innerText = stats.totalItemTerjual;
}

// Group data per bulan untuk chart
function groupByMonthForChart(data) {
    const grouped = new Map();
    
    data.forEach(item => {
        const date = parseTanggal(item.waktu);
        const key = `${date.getFullYear()}-${('0' + (date.getMonth() + 1)).slice(-2)}`;
        if (!grouped.has(key)) {
            grouped.set(key, { 
                bulan: key, 
                totalPendapatan: 0,
                totalTransaksi: 0,
                totalItem: 0
            });
        }
        const group = grouped.get(key);
        group.totalPendapatan += item.total_harga;
        group.totalTransaksi++;
        group.totalItem += item.total_item;
    });
    
    return Array.from(grouped.values()).sort((a, b) => a.bulan.localeCompare(b.bulan));
}

// Update chart
function updateChart(filteredData) {
    const monthlyData = groupByMonthForChart(filteredData);
    
    const labels = monthlyData.map(item => {
        const [year, month] = item.bulan.split('-');
        return new Date(year, month-1).toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });
    });
    
    const data = monthlyData.map(item => item.totalPendapatan);
    
    const ctx = document.getElementById('chartLaporan').getContext('2d');
    if (chartInstance) chartInstance.destroy();
    
    if (labels.length === 0) {
        chartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Tidak ada data'],
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: [0],
                    borderColor: '#ea580c',
                    backgroundColor: 'rgba(234, 88, 12, 0.1)'
                }]
            }
        });
        return;
    }
    
    chartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: data,
                borderColor: '#ea580c',
                backgroundColor: 'rgba(234, 88, 12, 0.1)',
                fill: true,
                tension: 0.3,
                pointBackgroundColor: '#ea580c',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) label += ': ';
                            if (context.parsed.y !== null) label += formatRupiah(context.parsed.y);
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { 
                        callback: function(value){ return formatRupiah(value); }
                    }
                }
            }
        }
    });
}

// Update info filter
function updateFilterInfo(startDate, endDate, totalData) {
    const filterInfo = document.getElementById('filterInfo');
    if (startDate || endDate) {
        let startText = startDate ? formatTanggalIndonesia(startDate) : 'awal';
        let endText = endDate ? formatTanggalIndonesia(endDate) : 'akhir';
        filterInfo.innerHTML = `<i class="bi bi-info-circle"></i> Menampilkan ${totalData} transaksi dari tanggal ${startText} sampai ${endText}`;
        filterInfo.classList.add('text-orange-600');
    } else {
        filterInfo.innerHTML = `<i class="bi bi-info-circle"></i> Menampilkan semua transaksi (${totalData})`;
        filterInfo.classList.remove('text-orange-600');
        filterInfo.classList.add('text-gray-500');
    }
}

function formatTanggalIndonesia(tanggalISO) {
    if (!tanggalISO) return '';
    let parts = tanggalISO.split('-');
    return `${parts[2]}/${parts[1]}/${parts[0]}`;
}

// Filter laporan utama
function filterLaporan() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    
    if (startDate && endDate && startDate > endDate) {
        alert('Tanggal awal tidak boleh lebih besar dari tanggal akhir!');
        return;
    }
    
    const data = loadData();
    const filteredData = filterDataByDate(data, startDate, endDate);
    
    updateStats(filteredData);
    updateTable(filteredData);
    updateTopProductsTable(filteredData);
    updateChart(filteredData);
    updateFilterInfo(startDate, endDate, filteredData.length);
}

// Reset filter
function resetFilter() {
    document.getElementById('startDate').value = '';
    document.getElementById('endDate').value = '';
    
    const data = loadData();
    
    updateStats(data);
    updateTable(data);
    updateTopProductsTable(data);
    updateChart(data);
    updateFilterInfo(null, null, data.length);
}

// Logout function
function performLogout() {
    if (confirm("Apakah Anda yakin ingin logout?")) {
        localStorage.removeItem('admin_token');
        localStorage.removeItem('admin_logged_in');
        sessionStorage.clear();
        window.location.href = "/login";
    }
}

// Sinkronisasi data
function syncDataFromHistory() {
    window.addEventListener('storage', function(event) {
        if (event.key === 'riwayat') {
            console.log('Data riwayat berubah, memuat ulang laporan...');
            resetFilter();
        }
    });
}

// Inisialisasi data dummy
function initializeData() {
    const existingData = localStorage.getItem('riwayat');
    
    if (!existingData || JSON.parse(existingData).length === 0) {
        const dummyData = [];
        const pelangganList = ['Budi Santoso', 'Siti Aminah', 'Ahmad Fauzi', 'Dewi Lestari', 'Rizky Pratama', 'Umum'];
        const daftarProduk = [
            { nama: "Spaghetti Carbonara", harga: 45000 },
            { nama: "Fettuccine Alfredo", harga: 55000 },
            { nama: "Spaghetti Aglio Olio", harga: 42000 },
            { nama: "Penne Arrabiata", harga: 48000 },
            { nama: "Lasagna Bolognese", harga: 58000 },
            { nama: "Ravioli Ricotta", harga: 52000 },
            { nama: "Mineral Water", harga: 5000 },
            { nama: "Lemon Tea", harga: 12000 },
            { nama: "Ice Coffee", harga: 15000 },
            { nama: "Garlic Bread", harga: 18000 }
        ];
        
        const now = new Date();
        
        const tanggalList = [];
        for (let i = 0; i < 15; i++) {
            let date = new Date(now);
            date.setDate(now.getDate() - i);
            tanggalList.push(date);
        }
        
        for(let i = 0; i < tanggalList.length; i++) {
            let date = tanggalList[i];
            let day = date.getDate().toString().padStart(2,'0');
            let month = (date.getMonth()+1).toString().padStart(2,'0');
            let year = date.getFullYear();
            let hour = (10 + i) % 24;
            let minute = i * 3 % 60;
            let waktuStr = `${day}/${month}/${year} ${hour.toString().padStart(2,'0')}:${minute.toString().padStart(2,'0')}:00`;
            
            let jumlahItem = Math.floor(Math.random() * 3) + 1;
            let items = [];
            let total = 0;
            
            let produkTerpilih = [...daftarProduk];
            for(let j = 0; j < jumlahItem && produkTerpilih.length > 0; j++) {
                let randomIndex = Math.floor(Math.random() * produkTerpilih.length);
                let produk = produkTerpilih[randomIndex];
                let qty = Math.floor(Math.random() * 3) + 1;
                let subtotal = produk.harga * qty;
                total += subtotal;
                
                items.push({
                    nama: produk.nama,
                    qty: qty,
                    harga: produk.harga,
                    subtotal: subtotal
                });
                
                produkTerpilih.splice(randomIndex, 1);
            }
            
            let bayar = total + (Math.random() * 20000);
            let kembalian = bayar - total;
            
            dummyData.push({
                id: (i+1).toString().padStart(3,'0'),
                pelanggan: pelangganList[Math.floor(Math.random() * pelangganList.length)],
                total: total,
                bayar: Math.ceil(bayar),
                kembalian: Math.ceil(kembalian),
                waktu: waktuStr,
                items: items,
                kasir: "Kasir " + (Math.floor(Math.random()*3)+1)
            });
        }
        
        localStorage.setItem('riwayat', JSON.stringify(dummyData));
        console.log('Data dummy created with', dummyData.length, 'transactions');
    }
}

// Halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    initializeData();
    
    const logoutBtn = document.getElementById('logoutButton');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            performLogout();
        });
    }
    
    loadData();
    resetFilter();
    syncDataFromHistory();
});

window.addEventListener('resize', () => { 
    if(chartInstance) chartInstance.resize(); 
});
</script>

</body>
</html>