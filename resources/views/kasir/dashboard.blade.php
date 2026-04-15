<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Kasir - Spaghetteria</title>

<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex h-screen">

<!-- ===================== -->
<!-- SIDEBAR KERANJANG -->
<!-- ===================== -->
<aside class="w-1/4 p-6 bg-white shadow-xl rounded-lg mt-6 h-full overflow-auto">

<h2 class="text-2xl font-bold text-center text-red-600 mb-4">
🛒 Keranjang Belanja
</h2>

<div class="font-bold mb-2 text-gray-700">
ID Pelanggan: <span id="idPelangganValue">PLG001</span>
</div>

<ul id="keranjang" class="space-y-2"></ul>

<div class="mt-6 font-bold flex justify-between items-center text-lg">
<p>Total: <span id="totalHarga" class="text-red-600">Rp0</span></p>

<button
class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition"
onclick="konfirmasiPesanan()">
✔ Konfirmasi
</button>
</div>

<!-- Tombol Logout -->
<div class="mt-6 pt-4 border-t">
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="w-full bg-gray-500 text-white py-2 rounded-lg hover:bg-gray-600 transition">
            🚪 Logout
        </button>
    </form>
</div>

</aside>


<!-- ===================== -->
<!-- MENU PRODUK -->
<!-- ===================== -->
<div class="flex-1 p-10 overflow-auto">

<main class="max-w-6xl mx-auto">

<h1 class="text-3xl font-bold text-center mb-6">
🍝 Selamat Datang di Spaghetteria
</h1>

@if($menus->count() > 0)
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

@foreach ($menus as $menu)

@php
$safeNama = preg_replace('/[^A-Za-z0-9]/','_',$menu->nama);
@endphp

<div class="bg-white p-4 rounded-xl shadow-lg text-center hover:scale-105 transition">

<img src="{{ asset($menu->gambar) }}" class="w-full h-48 object-cover rounded-lg" alt="{{ $menu->nama }}"
onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">

<h2 class="text-xl font-bold mt-2">
{{ $menu->nama }}
</h2>

<p class="text-gray-800 font-semibold text-lg">
Rp{{ number_format($menu->harga,0,',','.') }}
</p>

<p class="text-sm font-semibold 
{{ $menu->stok <= 5 ? 'text-red-500' : 'text-green-600' }}">
Stok: <span id="stok-{{ $safeNama }}">{{ $menu->stok }}</span>
</p>

<div class="flex justify-between mt-4 items-center">

<button
onclick="kurangiJumlah('{{ $safeNama }}')"
class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
-
</button>

<span class="jumlah text-lg font-bold" id="jumlah-{{ $safeNama }}">
0
</span>

<button
onclick="tambahJumlah('{{ $safeNama }}', {{ $menu->harga }}, '{{ addslashes($menu->nama) }}', {{ $menu->stok }})"
class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition
{{ $menu->stok <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
{{ $menu->stok <= 0 ? 'disabled' : '' }}>
+
</button>

</div>

</div>

@endforeach

</div>
@else
<div class="text-center py-12">
    <p class="text-gray-500 text-xl">Belum ada menu yang tersedia</p>
    <p class="text-gray-400 mt-2">Silakan tambahkan menu terlebih dahulu</p>
</div>
@endif

</main>

</div>


<!-- ===================== -->
<!-- SIDEBAR TIPE LAYANAN -->
<!-- ===================== -->
<aside class="w-1/5 p-6 bg-white shadow-xl rounded-lg mt-6 h-full flex flex-col">

<h2 class="text-xl font-bold text-center text-red-600 mb-4">
🍽 Tipe Layanan
</h2>

<label class="flex items-center mb-2">
<input type="radio" name="tipeLayanan" value="Dine In" checked>
<span class="ml-2">Dine In</span>
</label>

<label class="flex items-center">
<input type="radio" name="tipeLayanan" value="Take Away">
<span class="ml-2">Take Away</span>
</label>

</aside>


<script>
const keranjang = {};

// TAMBAH
function tambahJumlah(safeNama, harga, nama, stok)
{
    if(!keranjang[nama])
    {
        keranjang[nama] = {jumlah:0, harga:harga, stok:stok}
    }

    if(keranjang[nama].jumlah >= stok)
    {
        alert("Stok habis!");
        return;
    }

    keranjang[nama].jumlah++

    const jumlahElement = document.getElementById("jumlah-"+safeNama);
    const stokElement = document.getElementById("stok-"+safeNama);
    
    if(jumlahElement) jumlahElement.innerText = keranjang[nama].jumlah
    if(stokElement) stokElement.innerText = stok - keranjang[nama].jumlah

    updateKeranjang()
}

// KURANGI
function kurangiJumlah(safeNama)
{
    for(const nama in keranjang)
    {
        const keySafe = nama.replace(/[^A-Za-z0-9]/g,'_')

        if(keySafe === safeNama)
        {
            if(keranjang[nama].jumlah > 0)
            {
                keranjang[nama].jumlah--
                const jumlahElement = document.getElementById("jumlah-"+safeNama);
                const stokElement = document.getElementById("stok-"+safeNama);
                
                if(jumlahElement) jumlahElement.innerText = keranjang[nama].jumlah
                if(stokElement) stokElement.innerText = keranjang[nama].stok - keranjang[nama].jumlah
            }
            break
        }
    }

    updateKeranjang()
}

// UPDATE
function updateKeranjang()
{
    const list = document.getElementById("keranjang")
    if(!list) return;
    
    list.innerHTML=""

    let total = 0

    for(const nama in keranjang)
    {
        const item = keranjang[nama]

        if(item.jumlah > 0)
        {
            let li = document.createElement("li")
            li.className = "flex justify-between items-center border-b pb-2 mb-2"
            li.innerHTML = `<span>${nama} x ${item.jumlah}</span><span class="font-semibold">Rp${(item.harga * item.jumlah).toLocaleString("id-ID")}</span>`
            list.appendChild(li)

            total += item.harga * item.jumlah
        }
    }

    if(total === 0) {
        let emptyMsg = document.createElement("li")
        emptyMsg.className = "text-gray-400 text-center py-4"
        emptyMsg.innerText = "Keranjang kosong"
        list.appendChild(emptyMsg)
    }

    const totalElement = document.getElementById("totalHarga");
    if(totalElement) totalElement.innerHTML = "Rp"+total.toLocaleString("id-ID")
}

// SIMPAN
function konfirmasiPesanan()
{
    const idPelanggan = document.getElementById("idPelangganValue").innerText

    const tipeLayanan = document.querySelector('input[name="tipeLayanan"]:checked')
    if(!tipeLayanan) {
        alert("Pilih tipe layanan terlebih dahulu")
        return
    }

    const detail = []

    for(const nama in keranjang)
    {
        const item = keranjang[nama]

        if(item.jumlah>0)
        {
            detail.push({
                nama:nama,
                jumlah:item.jumlah,
                harga:item.harga
            })
        }
    }

    if(detail.length==0)
    {
        alert("Keranjang kosong")
        return
    }

    let total = detail.reduce((a,b)=>a+(b.harga*b.jumlah),0)

    fetch("{{ route('pesanan.simpan') }}",{
        method:"POST",
        headers:{
            "Content-Type":"application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body:JSON.stringify({
            id_pelanggan:idPelanggan,
            detail:detail,
            total_harga:total,
            tipe_layanan:tipeLayanan.value
        })
    })
    .then(res=>res.json())
    .then(data=>{
        if(data.success) {
            // Reset keranjang setelah sukses
            for(const nama in keranjang) {
                const safeNama = nama.replace(/[^A-Za-z0-9]/g,'_')
                const stokElem = document.getElementById("stok-"+safeNama)
                if(stokElem) {
                    const newStok = keranjang[nama].stok - keranjang[nama].jumlah
                    stokElem.innerText = newStok
                    // Update stok di object
                    keranjang[nama].stok = newStok
                }
                const jumlahElem = document.getElementById("jumlah-"+safeNama)
                if(jumlahElem) {
                    jumlahElem.innerText = "0"
                }
                // Reset jumlah
                keranjang[nama].jumlah = 0
            }
            
            updateKeranjang()
            alert("✅ Pesanan berhasil disimpan!")
            
            // Refresh halaman untuk update stok
            setTimeout(() => {
                window.location.reload()
            }, 1000)
        }
        else
        {
            alert(data.message || "Pesanan gagal disimpan")
        }
    })
    .catch((err)=>{
        console.error(err)
        alert("Gagal menyimpan pesanan. Periksa koneksi internet Anda.")
    })
}
</script>

</body>
</html>