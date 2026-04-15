<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Kasir - Spaghetteria</title>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 flex h-screen font-sans">

<!-- ================= SIDEBAR ================= -->
<aside class="w-1/4 bg-white shadow-lg p-5 overflow-auto">
    <h2 class="text-xl font-bold mb-2 text-red-600">Keranjang</h2>

    <!-- ID PESANAN -->
    <p class="text-sm text-gray-500 mb-1">
        ID Pesanan: <span id="idPesanan"></span>
    </p>

    <!-- ✅ ID PELANGGAN OTOMATIS -->
    <p class="text-sm text-gray-500 mb-3">
        ID Pelanggan: <span id="idPelangganText"></span>
    </p>

    <ul id="keranjang" class="space-y-2"></ul>

    <div class="mt-4 text-lg font-bold">
        Total: <span id="totalHarga">Rp0</span>
    </div>

    <button onclick="konfirmasiPesanan()" 
        class="mt-4 w-full bg-red-500 text-white py-2 rounded hover:bg-red-600">
        Konfirmasi
    </button>
</aside>

<!-- ================= MENU ================= -->
<div class="flex-1 p-6 overflow-auto">
    <div id="menuContainer" class="grid grid-cols-2 md:grid-cols-3 gap-5"></div>
</div>

<!-- ================= TIPE ================= -->
<aside class="w-1/5 bg-white shadow-lg p-5">
    <h2 class="text-lg font-bold mb-4 text-gray-700">Tipe Layanan</h2>

    <label class="flex items-center gap-2 mb-3 cursor-pointer">
        <input type="radio" name="tipeLayanan" value="Dine In" checked>
        <span>Dine In</span>
    </label>

    <label class="flex items-center gap-2 cursor-pointer">
        <input type="radio" name="tipeLayanan" value="Take Away">
        <span>Take Away</span>
    </label>
</aside>

<script>
// ================= GLOBAL =================
let keranjang = {};
let idPesanan = generateIdPesanan();
let idPelanggan = generateIdPelanggan(); // ✅ otomatis

// ================= GENERATE ID =================
function generateIdPesanan() {
    return "ORD" + new Date().getTime();
}

function generateIdPelanggan() {
    return "PLG" + Math.floor(Math.random() * 1000000);
}

// ================= LOAD PRODUK =================
async function loadProduk() {
    const res = await fetch('{{ route("api.produk.list") }}');
    const data = await res.json();

    if (data.success) renderProduk(data.produk);
}

// ================= RENDER PRODUK =================
function renderProduk(list) {
    const container = document.getElementById('menuContainer');
    container.innerHTML = '';
    keranjang = {};

    list.forEach(p => {
        const safe = p.nama.replace(/[^A-Za-z0-9]/g, '_');

        keranjang[p.nama] = {
            jumlah: 0,
            harga: p.harga,
            stok: p.stok
        };

        const gambar = p.gambar 
            ? `<img src="${p.gambar}" class="w-full h-32 object-cover rounded mb-2">`
            : `<div class="w-full h-32 bg-gray-200 flex items-center justify-center rounded mb-2 text-gray-400">No Image</div>`;

        container.innerHTML += `
        <div class="bg-white rounded shadow p-4 hover:shadow-lg transition">
            
            ${gambar}

            <h3 class="font-bold text-lg">${p.nama}</h3>
            <p class="text-red-500 font-semibold">Rp${Number(p.harga).toLocaleString()}</p>
            <p class="text-sm">Stok: <span id="stok-${safe}">${p.stok}</span></p>

            <div class="flex gap-2 mt-2 items-center">
                <button onclick="kurang('${p.nama}',${p.stok})" class="bg-gray-200 px-3 rounded">-</button>
                <span id="jml-${safe}">0</span>
                <button onclick="tambah('${p.nama}',${p.stok})" class="bg-red-500 text-white px-3 rounded">+</button>
            </div>
        </div>`;
    });

    updateKeranjang();
}

// ================= TAMBAH =================
function tambah(nama, stok) {
    if (keranjang[nama].jumlah >= stok) return;
    keranjang[nama].jumlah++;
    updateUI(nama, stok);
}

// ================= KURANG =================
function kurang(nama, stok) {
    if (keranjang[nama].jumlah <= 0) return;
    keranjang[nama].jumlah--;
    updateUI(nama, stok);
}

function updateUI(nama, stok){
    const safe = nama.replace(/[^A-Za-z0-9]/g, '_');

    document.getElementById("jml-"+safe).innerText = keranjang[nama].jumlah;
    document.getElementById("stok-"+safe).innerText = stok - keranjang[nama].jumlah;

    updateKeranjang();
}

// ================= KERANJANG =================
function updateKeranjang() {
    const list = document.getElementById("keranjang");
    list.innerHTML = "";

    let total = 0;

    for (let nama in keranjang) {
        let item = keranjang[nama];

        if (item.jumlah > 0) {
            total += item.jumlah * item.harga;

            list.innerHTML += `
            <li class="flex justify-between border-b py-1">
                <span>${nama} x${item.jumlah}</span>
                <span>Rp${(item.jumlah * item.harga).toLocaleString()}</span>
            </li>`;
        }
    }

    document.getElementById("totalHarga").innerText = "Rp" + total.toLocaleString();
}

// ================= KONFIRMASI =================
function konfirmasiPesanan() {
    let detail = [];
    let total = 0;

    for (let nama in keranjang) {
        let item = keranjang[nama];

        if (item.jumlah > 0) {
            detail.push({
                nama: nama,
                jumlah: item.jumlah,
                harga: item.harga
            });

            total += item.jumlah * item.harga;
        }
    }

    if (detail.length === 0) {
        Swal.fire("Oops!", "Keranjang kosong!", "warning");
        return;
    }

    const tipe = document.querySelector('input[name="tipeLayanan"]:checked').value;

    localStorage.setItem('order_to_process', JSON.stringify({
        id_pesanan: idPesanan,
        id_pelanggan: idPelanggan, // ✅ otomatis dikirim
        tipe_layanan: tipe,
        total_harga: total,
        details: detail
    }));

    Swal.fire({
        icon: 'success',
        title: 'Pesanan Berhasil!',
        text: 'Lanjut ke pembayaran',
        confirmButtonText: 'OK'
    }).then(() => {
        window.location.href = "{{ route('pembayaran') }}";
    });
}

// ================= INIT =================
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("idPesanan").innerText = idPesanan;
    document.getElementById("idPelangganText").innerText = idPelanggan;
    loadProduk();
});
</script>

</body>
</html>