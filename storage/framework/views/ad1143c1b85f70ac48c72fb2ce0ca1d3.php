<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin - Spaghetteria</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
.sidebar{
    width:230px;
    background:#ea580c;
    color:white;
    min-height:100vh;
    padding:20px;
    position:fixed;
    left:0;
    top:0;
    z-index:10;
}
.sidebar a{
    color:white;
    display:block;
    padding:10px;
    border-radius:6px;
    text-decoration:none;
    margin-bottom:8px;
}
.sidebar a:hover{
    background:#c2410c;
}
.sidebar a i{
    margin-right:10px;
}
.sidebar a.active {
    background: rgba(255,255,255,0.25);
    border-left: 3px solid white;
}
.main-content {
    margin-left: 230px;
    padding: 30px;
    background: #fef9f1;
    min-height: 100vh;
}
.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
}
</style>
</head>
<body>

<div class="flex">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h4 class="mb-6 text-xl font-bold">
            <i class="bi bi-speedometer2"></i> Admin Spaghetti
        </h4>
        
        <ul>
            <li><a href="/admin/dashboard" class="active"><i class="bi bi-house"></i> Dashboard</a></li>
            <li><a href="/admin/produk"><i class="bi bi-box"></i> Kelola Produk</a></li>
            <li><a href="/kelola-akun-kasir"><i class="bi bi-people"></i> Kelola Kasir</a></li>
            <li><a href="/pantau-transaksi"><i class="bi bi-graph-up"></i> Pantau Transaksi</a></li>
            <li><a href="/log-activity"><i class="bi bi-clock-history"></i> Log Activity</a></li>
            <li><a href="/admin/laporan"><i class="bi bi-file-earmark-text"></i> Laporan</a></li>
        </ul>
    </div>

    <!-- CONTENT -->
    <div class="main-content">

        <h1 class="text-3xl font-bold mb-6">Dashboard Admin</h1>

        <!-- Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 card">
                <div class="flex items-center">
                    <div class="p-3 bg-orange-500 rounded-full text-white">
                        <i class="bi bi-box text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Total Produk</p>
                        <p class="text-2xl font-bold" id="totalProduk">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 card">
                <div class="flex items-center">
                    <div class="p-3 bg-orange-500 rounded-full text-white">
                        <i class="bi bi-cart text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Transaksi Hari Ini</p>
                        <p class="text-2xl font-bold" id="transaksiHariIni">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 card">
                <div class="flex items-center">
                    <div class="p-3 bg-orange-500 rounded-full text-white">
                        <i class="bi bi-cash-stack text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Pendapatan</p>
                        <p class="text-2xl font-bold" id="pendapatanHariIni">Rp0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 card">
                <div class="flex items-center">
                    <div class="p-3 bg-orange-500 rounded-full text-white">
                        <i class="bi bi-people text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Total Kasir</p>
                        <p class="text-2xl font-bold" id="totalKasir">0</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">Grafik Penjualan 7 Hari Terakhir</h2>
            <canvas id="chartPenjualan" height="100"></canvas>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// ==================== KEY STORAGE ====================
const PRODUK_STORAGE_KEY = 'produk_spaghetteria';
const TRANSAKSI_STORAGE_KEY = 'riwayat_transaksi_spaghetteria';
const KASIR_STORAGE_KEY = 'data_kasir_spaghetteria';

// ==================== DATA DEFAULT ====================
const DEFAULT_PRODUK = [
    { id:1, nama:"Spaghetti Carbonara", kategori:"Pasta Italia", harga:45000, stok:50, created_at:new Date().toISOString() },
    { id:2, nama:"Fettuccine Alfredo", kategori:"Pasta Italia", harga:48000, stok:45, created_at:new Date().toISOString() },
    { id:3, nama:"Spaghetti Aglio Olio", kategori:"Pasta Italia", harga:38000, stok:60, created_at:new Date().toISOString() },
    { id:4, nama:"Lasagna Bolognese", kategori:"Lasagna", harga:55000, stok:35, created_at:new Date().toISOString() },
    { id:5, nama:"Penne Arrabbiata", kategori:"Pasta Italia", harga:40000, stok:40, created_at:new Date().toISOString() },
    { id:6, nama:"Spaghetti Bolognese", kategori:"Pasta Italia", harga:47000, stok:55, created_at:new Date().toISOString() },
    { id:7, nama:"Mac & Cheese", kategori:"Macaroni", harga:35000, stok:30, created_at:new Date().toISOString() }
];

const DEFAULT_KASIR = [
    { id:1, nama:"Budi Santoso", username:"kasir1", role:"kasir", aktif:true, created_at:new Date().toISOString() },
    { id:2, nama:"Siti Aminah", username:"kasir2", role:"kasir", aktif:true, created_at:new Date().toISOString() },
    { id:3, nama:"Ahmad Rizal", username:"kasir3", role:"kasir", aktif:true, created_at:new Date().toISOString() }
];

// ==================== LOCALSTORAGE UTILITY ====================
function getProduk() {
    try {
        const stored = localStorage.getItem(PRODUK_STORAGE_KEY);
        if(stored && JSON.parse(stored).length>0) return JSON.parse(stored);
        localStorage.setItem(PRODUK_STORAGE_KEY, JSON.stringify(DEFAULT_PRODUK));
        return [...DEFAULT_PRODUK];
    } catch(e){ return [...DEFAULT_PRODUK]; }
}
function getRiwayatTransaksi() {
    try { return JSON.parse(localStorage.getItem(TRANSAKSI_STORAGE_KEY)) || []; }
    catch(e){ return []; }
}
function getKasir() {
    try {
        const stored = localStorage.getItem(KASIR_STORAGE_KEY);
        if(stored && JSON.parse(stored).length>0) return JSON.parse(stored);
        localStorage.setItem(KASIR_STORAGE_KEY, JSON.stringify(DEFAULT_KASIR));
        return [...DEFAULT_KASIR];
    } catch(e){ return [...DEFAULT_KASIR]; }
}

// ==================== UTILITY ====================
function formatRupiah(angka){
    if(!angka||angka===0) return 'Rp0';
    return 'Rp'+angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
function getTodayString(){
    const today=new Date();
    const d=today.getDate().toString().padStart(2,'0');
    const m=(today.getMonth()+1).toString().padStart(2,'0');
    const y=today.getFullYear();
    return `${d}/${m}/${y}`;
}

// ==================== DASHBOARD FUNCTIONS ====================
function hitungStatistikDashboard(){
    const produk=getProduk();
    const riwayat=getRiwayatTransaksi();
    const kasir=getKasir();
    const todayStr=getTodayString();
    let totalTransaksiHariIni=0, totalPendapatanHariIni=0;

    for(let i=0;i<riwayat.length;i++){
        const item=riwayat[i];
        if(item.waktu){
            const tanggal=item.waktu.split(' ')[0];
            if(tanggal===todayStr){
                totalTransaksiHariIni++;
                totalPendapatanHariIni+=item.total||0;
            }
        }
    }

    const kasirAktif=kasir.filter(k=>k.role==='kasir' && k.aktif!==false);

    return {
        totalProduk:produk.length,
        totalTransaksiHariIni:totalTransaksiHariIni,
        totalPendapatanHariIni:totalPendapatanHariIni,
        totalKasir:kasirAktif.length,
        semuaTransaksi:riwayat
    };
}

function hitungPenjualan7Hari(riwayat){
    const result=[];
    for(let i=6;i>=0;i--){
        const date=new Date();
        date.setDate(date.getDate()-i);
        const day=date.getDate().toString().padStart(2,'0');
        const month=(date.getMonth()+1).toString().padStart(2,'0');
        const year=date.getFullYear();
        const tanggalFilter=`${day}/${month}/${year}`;
        const label=`${day}/${month}`;
        let totalPenjualan=0;
        for(let j=0;j<riwayat.length;j++){
            const item=riwayat[j];
            if(item.waktu){
                const tanggalTransaksi=item.waktu.split(' ')[0];
                if(tanggalTransaksi===tanggalFilter) totalPenjualan+=item.total||0;
            }
        }
        result.push({tanggal:label,total:totalPenjualan});
    }
    return result;
}

// ==================== CHART ====================
let myChart=null;
function updateChart(penjualan7Hari){
    const ctx=document.getElementById('chartPenjualan');
    if(myChart) myChart.destroy();
    myChart=new Chart(ctx,{
        type:'bar',
        data:{
            labels:penjualan7Hari.map(i=>i.tanggal),
            datasets:[{
                label:'Penjualan (Rp)',
                data:penjualan7Hari.map(i=>i.total),
                backgroundColor:'#ea580c',
                borderRadius:8,
                barPercentage:0.65,
                categoryPercentage:0.8
            }]
        },
        options:{
            responsive:true,
            plugins:{
                legend:{display:true,position:'top'},
                tooltip:{
                    callbacks:{
                        label:function(context){return 'Total: '+formatRupiah(context.raw);}
                    }
                }
            },
            scales:{
                y:{
                    beginAtZero:true,
                    ticks:{
                        callback:function(value){return formatRupiah(value);}
                    },
                    title:{
                        display:true,
                        text:'Pendapatan (Rp)',
                        font:{weight:'bold'}
                    }
                },
                x:{
                    title:{
                        display:true,
                        text:'Tanggal',
                        font:{weight:'bold'}
                    }
                }
            }
        }
    });
}

// ==================== UPDATE DASHBOARD ====================
function updateDashboard(){
    const stats=hitungStatistikDashboard();
    const penjualan7Hari=hitungPenjualan7Hari(stats.semuaTransaksi);
    document.getElementById('totalProduk').innerText=stats.totalProduk;
    document.getElementById('transaksiHariIni').innerText=stats.totalTransaksiHariIni;
    document.getElementById('pendapatanHariIni').innerText=formatRupiah(stats.totalPendapatanHariIni);
    document.getElementById('totalKasir').innerText=stats.totalKasir;
    updateChart(penjualan7Hari);
}

// ==================== SAMPLE TRANSAKSI ====================
function createSampleTransactions(){
    const riwayat=getRiwayatTransaksi();
    if(riwayat.length>0) return;
    const produk=getProduk();
    const sampleTransactions=[];
    const today=new Date();

    for(let i=0;i<7;i++){
        const date=new Date();
        date.setDate(today.getDate()-i);
        const d=date.getDate().toString().padStart(2,'0');
        const m=(date.getMonth()+1).toString().padStart(2,'0');
        const y=date.getFullYear();
        const dateStr=`${d}/${m}/${y}`;
        const numTransactions=2+Math.floor(Math.random()*4);

        for(let t=0;t<numTransactions;t++){
            const hour=9+Math.floor(Math.random()*12);
            const minute=Math.floor(Math.random()*60);
            const second=Math.floor(Math.random()*60);
            const waktu=`${dateStr} ${hour.toString().padStart(2,'0')}:${minute.toString().padStart(2,'0')}:${second.toString().padStart(2,'0')}`;
            const numItems=1+Math.floor(Math.random()*4);
            const items=[];
            let total=0;
            const shuffled=[...produk].sort(()=>Math.random()-0.5);
            for(let j=0;j<numItems && j<shuffled.length;j++){
                const prod=shuffled[j];
                const quantity=1+Math.floor(Math.random()*3);
                const subtotal=prod.harga*quantity;
                items.push({id:prod.id,nama:prod.nama,harga:prod.harga,quantity:quantity,subtotal:subtotal,kategori:prod.kategori});
                total+=subtotal;
            }
            sampleTransactions.push({id:Date.now()+i*1000+t,waktu:waktu,items:items,total:total,metode_pembayaran:Math.random()>0.5?'Tunai':'QRIS',kasir:['Budi Santoso','Siti Aminah','Ahmad Rizal'][Math.floor(Math.random()*3)]});
        }
    }

    sampleTransactions.sort((a,b)=>new Date(a.waktu.split(' ')[0].split('/').reverse().join('-')+' '+a.waktu.split(' ')[1])-new Date(b.waktu.split(' ')[0].split('/').reverse().join('-')+' '+b.waktu.split(' ')[1]));
    localStorage.setItem(TRANSAKSI_STORAGE_KEY,JSON.stringify(sampleTransactions));
}

// ==================== INIT ====================
document.addEventListener('DOMContentLoaded',function(){
    createSampleTransactions();
    setTimeout(()=>{ updateDashboard(); },100);
});

</script>

</body>
</html><?php /**PATH C:\xamppbaruu\htdocs\laravel\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>