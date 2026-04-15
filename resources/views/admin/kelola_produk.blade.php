<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Kelola Produk - Spaghetteria</title>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* Sidebar styling - Warna Oranye */
.sidebar {
    width: 260px;
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    color: white;
    min-height: 100vh;
    padding: 25px 20px;
    box-shadow: 2px 0 10px rgba(0,0,0,0.1);
    position: fixed;
    left: 0;
    top: 0;
    z-index: 10;
}

.sidebar h4 {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 2px solid rgba(255,255,255,0.3);
    display: flex;
    align-items: center;
    gap: 10px;
}

.sidebar a {
    color: white;
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 15px;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.3s ease;
    margin-bottom: 8px;
    font-weight: 500;
}

.sidebar a i {
    font-size: 1.2rem;
    width: 24px;
}

.sidebar a:hover {
    background: rgba(255,255,255,0.2);
    transform: translateX(5px);
}

.sidebar a.active {
    background: rgba(255,255,255,0.25);
    border-left: 3px solid white;
}

/* Main content */
.main-content {
    margin-left: 260px;
    padding: 30px;
    min-height: 100vh;
    background: #fef9f1;
}

/* Header styling */
.page-header {
    background: white;
    border-radius: 15px;
    padding: 20px 25px;
    margin-bottom: 25px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    border-left: 5px solid #f97316;
}

.page-header h1 {
    font-size: 1.8rem;
    font-weight: bold;
    color: #2d3748;
    margin: 0;
}

.page-header p {
    color: #718096;
    margin: 5px 0 0 0;
    font-size: 0.9rem;
}

/* Tombol tambah */
.btn-add {
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    color: white;
    padding: 12px 24px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 12px rgba(249,115,22,0.3);
}

.btn-add:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(249,115,22,0.4);
}

/* Form styling */
.form-container {
    background: white;
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 25px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    border: 1px solid #ffe4cc;
}

.form-container h2 {
    font-size: 1.3rem;
    font-weight: bold;
    color: #f97316;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #ffe4cc;
}

.form-input {
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 10px 12px;
    transition: all 0.3s ease;
    width: 100%;
}

.form-input:focus {
    outline: none;
    border-color: #f97316;
    box-shadow: 0 0 0 3px rgba(249,115,22,0.1);
}

/* Tabel styling */
.table-container {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.table-header {
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    color: white;
}

.table-header th {
    padding: 15px;
    font-weight: 600;
    text-align: left;
}

.table-row {
    border-bottom: 1px solid #f0f0f0;
    transition: all 0.3s ease;
}

.table-row:hover {
    background: #fef9f1;
}

.table-row td {
    padding: 15px;
    vertical-align: middle;
}

/* Button styling */
.btn-edit {
    background: #fbbf24;
    color: #78350f;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.btn-edit:hover {
    background: #f59e0b;
    transform: translateY(-1px);
}

.btn-delete {
    background: #ef4444;
    color: white;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.btn-delete:hover {
    background: #dc2626;
    transform: translateY(-1px);
}

.btn-submit {
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    color: white;
    padding: 10px 24px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-submit:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(249,115,22,0.3);
}

.btn-cancel {
    background: #9ca3af;
    color: white;
    padding: 10px 24px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-cancel:hover {
    background: #6b7280;
}

/* Notifikasi */
.alert-fade {
    animation: fadeOut 3s ease forwards;
}

@keyframes fadeOut {
    0% { opacity: 1; transform: translateX(0); }
    70% { opacity: 1; transform: translateX(0); }
    100% { opacity: 0; transform: translateX(100%); display: none; }
}

/* Gambar produk */
.product-image {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 10px;
    border: 2px solid #ffe4cc;
}

/* Responsive */
@media (max-width: 768px) {
    .sidebar {
        width: 80px;
        padding: 20px 10px;
    }
    .sidebar h4 {
        font-size: 0;
        justify-content: center;
    }
    .sidebar h4 i {
        font-size: 1.5rem;
    }
    .sidebar a span {
        display: none;
    }
    .sidebar a i {
        font-size: 1.3rem;
        margin: 0;
    }
    .main-content {
        margin-left: 80px;
    }
}
</style>
</head>

<body>

<!-- SIDEBAR - WARNA ORANYE -->
<div class="sidebar">
    <h4>
        <i class="bi bi-shop"></i>
        <span>Spaghetteria</span>
    </h4>

    <ul>
        <li><a href="/admin/dashboard"><i class="bi bi-house"></i> Dashboard</a></li>
        <li><a href="/admin/produk" class="active"><i class="bi bi-box"></i> Kelola Produk</a></li>
        <li><a href="/kelola-akun-kasir"><i class="bi bi-people"></i> Kelola Kasir</a></li>
        <li><a href="/pantau-transaksi"><i class="bi bi-graph-up"></i> Pantau Transaksi</a></li>
        <li><a href="/log-activity"><i class="bi bi-clock-history"></i> Log Activity</a></li>
        <li><a href="/admin/laporan"><i class="bi bi-file-earmark-text"></i> Laporan</a></li>
    </ul>
</div>

<!-- MAIN CONTENT -->
<div class="main-content">

    <!-- Header -->
    <div class="page-header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1>
                    <i class="bi bi-box-seam text-orange-500"></i> Kelola Produk
                </h1>
                <p>Kelola data menu produk Spaghetteria</p>
            </div>
            <button onclick="toggleForm()" class="btn-add">
                <i class="bi bi-plus-lg"></i> Tambah Produk
            </button>
        </div>
    </div>

    <!-- NOTIF AREA -->
    <div id="notificationArea" class="mb-4"></div>

    <!-- FORM TAMBAH PRODUK -->
    <div id="formProduk" class="form-container hidden">
        <h2>
            <i class="bi bi-plus-circle"></i> Tambah Produk Baru
        </h2>
        <form id="tambahProdukForm" enctype="multipart/form-data">
            @csrf

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk *</label>
                    <input type="text" id="nama_produk" name="nama" placeholder="Contoh: Spaghetti Carbonara" class="form-input" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori *</label>
                    <input type="text" id="kategori_produk" name="kategori" placeholder="Contoh: Pasta Italia" class="form-input" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) *</label>
                    <input type="number" id="harga_produk" name="harga" placeholder="0" class="form-input" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stok *</label>
                    <input type="number" id="stok_produk" name="stok" placeholder="0" class="form-input" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea id="deskripsi_produk" name="deskripsi" placeholder="Deskripsi produk" class="form-input" rows="2"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bahan</label>
                    <textarea id="bahan_produk" name="bahan" placeholder="Bahan-bahan produk" class="form-input" rows="2"></textarea>
                </div>
                <div style="grid-column: span 2;">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk</label>
                    <input type="file" id="gambar_produk" name="gambar" class="form-input" accept="image/*">
                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, GIF. Kosongkan jika tidak ingin upload gambar</p>
                </div>
            </div>

            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn-submit">
                    <i class="bi bi-check-lg"></i> Simpan
                </button>
                <button type="button" onclick="toggleForm()" class="btn-cancel">
                    <i class="bi bi-x-lg"></i> Batal
                </button>
            </div>
        </form>
    </div>

    <!-- FORM EDIT PRODUK -->
    <div id="formEdit" class="form-container hidden">
        <h2>
            <i class="bi bi-pencil-square"></i> Edit Produk
        </h2>
        <form id="editForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="id" id="edit_id">

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk *</label>
                    <input type="text" id="edit_nama" name="nama" class="form-input" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori *</label>
                    <input type="text" id="edit_kategori" name="kategori" class="form-input" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) *</label>
                    <input type="number" id="edit_harga" name="harga" class="form-input" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stok *</label>
                    <input type="number" id="edit_stok" name="stok" class="form-input" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea id="edit_deskripsi" name="deskripsi" class="form-input" rows="2"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bahan</label>
                    <textarea id="edit_bahan" name="bahan" class="form-input" rows="2"></textarea>
                </div>
                <div style="grid-column: span 2;">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Baru (opsional)</label>
                    <input type="file" name="gambar" id="edit_gambar" class="form-input" accept="image/*">
                    <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengubah gambar</p>
                </div>
            </div>

            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn-submit">
                    <i class="bi bi-arrow-repeat"></i> Update
                </button>
                <button type="button" onclick="closeEditForm()" class="btn-cancel">
                    <i class="bi bi-x-lg"></i> Batal
                </button>
            </div>
        </form>
    </div>

    <!-- TABEL PRODUK -->
    <div class="table-container">
        <table style="width: 100%;">
            <thead class="table-header">
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th style="width: 120px;">Harga</th>
                    <th style="width: 80px;">Stok</th>
                    <th style="width: 100px;">Gambar</th>
                    <th style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="produkTableBody">
                @php $no = 1; @endphp
                @foreach($produkList as $produk)
                <tr class="table-row" data-id="{{ $produk->id }}">
                    <td style="text-align: center; font-weight: bold;">{{ $no++ }}</td>
                    <td class="nama-cell">{{ $produk->nama }}</td>
                    <td class="kategori-cell">{{ $produk->kategori }}</td>
                    <td class="harga-cell">Rp{{ number_format($produk->harga,0,',','.') }}</td>
                    <td class="stok-cell">{{ $produk->stok }}</td>
                    <td class="gambar-cell">
                        @if($produk->gambar)
                            <img src="{{ asset($produk->gambar) }}" class="product-image">
                        @else
                            <span style="color: #9ca3af;">-</span>
                        @endif
                    </td>
                    <td>
                        <button onclick="editProduk(
                            '{{ $produk->id }}',
                            '{{ addslashes($produk->nama) }}',
                            '{{ addslashes($produk->kategori) }}',
                            '{{ $produk->harga }}',
                            '{{ $produk->stok }}',
                            '{{ addslashes($produk->deskripsi ?? '') }}',
                            '{{ addslashes($produk->bahan ?? '') }}'
                        )" class="btn-edit">
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                        <button onclick="hapusProduk({{ $produk->id }})" class="btn-delete">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<script>
// Fungsi untuk menampilkan notifikasi
function showNotification(message, type = 'success') {
    const notifArea = document.getElementById('notificationArea');
    const bgColor = type === 'success' ? '#10b981' : '#ef4444';
    const icon = type === 'success' ? 'bi-check-circle' : 'bi-exclamation-triangle';
    
    const notifDiv = document.createElement('div');
    notifDiv.style.cssText = `
        background: ${bgColor};
        color: white;
        padding: 12px 20px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        animation: fadeOut 3s ease forwards;
        margin-bottom: 10px;
    `;
    notifDiv.innerHTML = `
        <i class="bi ${icon}" style="font-size: 1.2rem;"></i>
        <span>${message}</span>
        <i class="bi bi-x-circle" style="margin-left: auto; cursor: pointer;" onclick="this.parentElement.remove()"></i>
    `;
    
    notifArea.appendChild(notifDiv);
    
    setTimeout(() => {
        if (notifDiv.parentElement) {
            notifDiv.remove();
        }
    }, 3000);
}

// Fungsi untuk memberitahu halaman kasir bahwa data produk berubah
function notifyKasirToRefresh() {
    // Simpan timestamp ke localStorage
    const timestamp = Date.now();
    localStorage.setItem('refreshProduk_' + timestamp, timestamp.toString());
    
    // Hapus item lama setelah 1 detik (biar trigger storage event)
    setTimeout(() => {
        localStorage.removeItem('refreshProduk_' + timestamp);
    }, 1000);
    
    console.log('Notifikasi dikirim ke halaman kasir - produk telah berubah');
}

// Fungsi update nomor urut
function updateRowNumbers() {
    const rows = document.querySelectorAll('#produkTableBody tr');
    rows.forEach((row, index) => {
        const noCell = row.cells[0];
        if (noCell) {
            noCell.textContent = index + 1;
        }
    });
}

// TAMPILKAN FORM TAMBAH
function toggleForm() {
    const form = document.getElementById('formProduk');
    form.classList.toggle('hidden');
    if (!form.classList.contains('hidden')) {
        document.getElementById('tambahProdukForm').reset();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

// TUTUP FORM EDIT
function closeEditForm() {
    document.getElementById('formEdit').classList.add('hidden');
    document.getElementById('editForm').reset();
}

// TAMBAH PRODUK VIA AJAX
document.getElementById('tambahProdukForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('{{ route("produk.store") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const newRow = createTableRow(data.produk);
            document.getElementById('produkTableBody').insertAdjacentHTML('afterbegin', newRow);
            updateRowNumbers();
            
            document.getElementById('tambahProdukForm').reset();
            document.getElementById('formProduk').classList.add('hidden');
            
            showNotification(data.message, 'success');
            
            // Kirim notifikasi ke halaman kasir
            notifyKasirToRefresh();
            
        } else {
            showNotification(data.message || 'Gagal menambahkan produk', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan pada server', 'error');
    });
});

// Fungsi untuk membuat baris tabel
function createTableRow(produk) {
    const hargaFormatted = new Intl.NumberFormat('id-ID').format(produk.harga);
    const gambarHtml = produk.gambar 
        ? `<img src="${produk.gambar}?t=${Date.now()}" class="product-image">`
        : `<span style="color: #9ca3af;">-</span>`;
    
    const currentRows = document.querySelectorAll('#produkTableBody tr');
    const nextNumber = currentRows.length + 1;
    
    return `
        <tr class="table-row" data-id="${produk.id}">
            <td style="text-align: center; font-weight: bold;">${nextNumber}</td>
            <td class="nama-cell">${escapeHtml(produk.nama)}</td>
            <td class="kategori-cell">${escapeHtml(produk.kategori)}</td>
            <td class="harga-cell">Rp${hargaFormatted}</td>
            <td class="stok-cell">${produk.stok}</td>
            <td class="gambar-cell">${gambarHtml}</td>
            <td>
                <button onclick="editProduk(
                    '${produk.id}',
                    '${escapeJsString(produk.nama)}',
                    '${escapeJsString(produk.kategori)}',
                    '${produk.harga}',
                    '${produk.stok}',
                    '${escapeJsString(produk.deskripsi || '')}',
                    '${escapeJsString(produk.bahan || '')}'
                )" class="btn-edit">
                    <i class="bi bi-pencil"></i> Edit
                </button>
                <button onclick="hapusProduk(${produk.id})" class="btn-delete">
                    <i class="bi bi-trash"></i> Hapus
                </button>
            </td>
        </tr>
    `;
}

// Helper functions
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function escapeJsString(str) {
    if (!str) return '';
    return str.replace(/\\/g, '\\\\').replace(/'/g, "\\'").replace(/"/g, '\\"').replace(/\n/g, '\\n');
}

// EDIT PRODUK
function editProduk(id, nama, kategori, harga, stok, deskripsi = '', bahan = '') {
    const formEdit = document.getElementById('formEdit');
    formEdit.classList.remove('hidden');
    
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_kategori').value = kategori;
    document.getElementById('edit_harga').value = harga;
    document.getElementById('edit_stok').value = stok;
    document.getElementById('edit_deskripsi').value = deskripsi;
    document.getElementById('edit_bahan').value = bahan;
    document.getElementById('edit_gambar').value = '';
    
    document.getElementById('editForm').action = `/admin/produk/${id}`;
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// UPDATE PRODUK
document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const id = document.getElementById('edit_id').value;
    const formData = new FormData(this);
    formData.append('_method', 'PUT');
    
    fetch(`/admin/produk/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const row = document.querySelector(`tbody tr[data-id="${id}"]`);
            if (row) {
                row.cells[1].textContent = data.produk.nama;
                row.cells[2].textContent = data.produk.kategori;
                const hargaFormatted = new Intl.NumberFormat('id-ID').format(data.produk.harga);
                row.cells[3].innerHTML = `Rp${hargaFormatted}`;
                row.cells[4].textContent = data.produk.stok;
                
                const gambarCell = row.cells[5];
                if (data.produk.gambar) {
                    gambarCell.innerHTML = `<img src="${data.produk.gambar}?t=${Date.now()}" class="product-image">`;
                } else {
                    gambarCell.innerHTML = `<span style="color: #9ca3af;">-</span>`;
                }
            }
            
            document.getElementById('formEdit').classList.add('hidden');
            document.getElementById('editForm').reset();
            
            showNotification(data.message, 'success');
            
            // Kirim notifikasi ke halaman kasir
            notifyKasirToRefresh();
            
        } else {
            showNotification(data.message || 'Gagal mengupdate produk', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan pada server', 'error');
    });
});

// HAPUS PRODUK
function hapusProduk(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Tindakan ini tidak dapat dibatalkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="bi bi-trash"></i> Ya, hapus!',
        cancelButtonText: '<i class="bi bi-x-lg"></i> Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/produk/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const row = document.querySelector(`tbody tr[data-id="${id}"]`);
                    if (row) {
                        row.remove();
                        updateRowNumbers();
                    }
                    showNotification(data.message, 'success');
                    
                    // Kirim notifikasi ke halaman kasir
                    notifyKasirToRefresh();
                    
                } else {
                    showNotification(data.message || 'Gagal menghapus produk', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan pada server', 'error');
            });
        }
    });
}

// Inisialisasi
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('formEdit').classList.add('hidden');
    updateRowNumbers();
});

// LISTENER AUTO REFRESH DARI HALAMAN ADMIN
window.addEventListener('storage', function(e) {
    if (e.key && e.key.startsWith('refreshProduk_')) {
        console.log('Produk berubah, reload...');
        loadProduk(); // reload data produk
    }
});
</script>

</body>
</html>