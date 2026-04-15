<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Log Activity - Admin Spaghetti</title>

<!-- Tailwind + Bootstrap -->
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<!-- Font Awesome (optional, masih dipakai di tabel) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
body {
    background: #f8f9fa;
}

/* SIDEBAR BARU */
.sidebar{
    width:230px;
    background:#ea580c;
    color:white;
    min-height:100vh;
    padding:20px;
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

/* CONTENT */
.content {
    width: 100%;
    padding: 30px;
}

/* HEADER */
.header {
    background: linear-gradient(135deg, #d35400, #e67e22);
    color: white;
    padding: 20px 25px;
    border-radius: 15px;
    margin-bottom: 20px;
}

/* SEARCH */
.search-box input {
    border: none;
    outline: none;
}

/* TABLE */
.table-hover tbody tr:hover {
    background: #fff3e0;
}

.badge-user {
    background: #f0f0f0;
    padding: 5px 12px;
    border-radius: 30px;
    font-size: 0.85rem;
}

/* MODAL */
.detail-label {
    font-weight: bold;
    width: 120px;
    display: inline-block;
}
</style>
</head>

<body class="bg-gray-100">

<div class="flex">

<!-- ================= SIDEBAR ================= -->
<div class="sidebar">
    <h4 class="mb-6 text-xl font-bold">
        <i class="bi bi-speedometer2"></i> Admin Spaghetti
    </h4>
    
    <ul>
        <li><a href="/admin/dashboard"><i class="bi bi-house"></i> Dashboard</a></li>
        <li><a href="/admin/produk"><i class="bi bi-box"></i> Kelola Produk</a></li>
        <li><a href="/kelola-akun-kasir"><i class="bi bi-people"></i> Kelola Kasir</a></li>
        <li><a href="/pantau-transaksi"><i class="bi bi-graph-up"></i> Pantau Transaksi</a></li>
        <li><a href="/log-activity" style="background:#c2410c;"><i class="bi bi-clock-history"></i> Log Activity</a></li>
        <li><a href="/admin/laporan"><i class="bi bi-file-earmark-text"></i> Laporan</a></li>
    </ul>
</div>

<!-- ================= CONTENT ================= -->
<div class="content">

    <div class="header">
        <h2><i class="fas fa-clipboard-list"></i> Log Activity</h2>
        <p class="mb-0 opacity-75">Riwayat lengkap aktivitas sistem & pengguna</p>
    </div>

    <div class="card shadow border-0">
        <div class="card-body">

            <!-- FILTER -->
            <div class="d-flex justify-content-between mb-3 flex-wrap gap-2">
                
                <div class="d-flex gap-2 flex-wrap">
                    <select id="filterUser" class="form-select form-select-sm w-auto">
                        <option value="">Semua User</option>
                        @foreach($logs as $log)
                            <option value="{{ $log['user'] }}">{{ $log['user'] }}</option>
                        @endforeach
                    </select>

                    <select id="filterActivity" class="form-select form-select-sm w-auto">
                        <option value="">Semua Aktivitas</option>
                        <option value="Tambah">Tambah</option>
                        <option value="Edit">Edit</option>
                        <option value="Hapus">Hapus</option>
                        <option value="Login">Login</option>
                        <option value="Logout">Logout</option>
                    </select>
                </div>

                <div class="bg-white px-3 rounded shadow-sm border">
                    <input type="text" id="searchLog" placeholder="Cari..." class="p-2">
                </div>

            </div>

            <!-- TABLE -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Waktu</th>
                            <th>Aktivitas</th>
                            <th>User</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="logTableBody">
                        @foreach($logs as $i => $log)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $log['waktu'] }}</td>
                            <td>{{ $log['aktivitas'] }}</td>
                            <td>{{ $log['user'] }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm detail-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailModal"
                                    data-user="{{ $log['user'] }}"
                                    data-waktu="{{ $log['waktu'] }}"
                                    data-aktivitas="{{ $log['aktivitas'] }}"
                                    data-detail="{{ $log['detail'] ?? '-' }}">
                                    Detail
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
</div>

<!-- ================= MODAL ================= -->
<div class="modal fade" id="detailModal">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header bg-warning">
    <h5>Detail Aktivitas</h5>
</div>

<div class="modal-body">
    <p><span class="detail-label">User:</span> <span id="dUser"></span></p>
    <p><span class="detail-label">Waktu:</span> <span id="dWaktu"></span></p>
    <p><span class="detail-label">Aktivitas:</span> <span id="dAktivitas"></span></p>
    <p><span class="detail-label">Detail:</span> <span id="dDetail"></span></p>
</div>

</div>
</div>
</div>

<!-- ================= SCRIPT ================= -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// MODAL
document.querySelectorAll('.detail-btn').forEach(btn=>{
    btn.addEventListener('click',()=>{
        document.getElementById('dUser').innerText = btn.dataset.user;
        document.getElementById('dWaktu').innerText = btn.dataset.waktu;
        document.getElementById('dAktivitas').innerText = btn.dataset.aktivitas;
        document.getElementById('dDetail').innerText = btn.dataset.detail;
    });
});

// SEARCH
document.getElementById('searchLog').addEventListener('keyup', function(){
    let val = this.value.toLowerCase();
    document.querySelectorAll('#logTableBody tr').forEach(row=>{
        row.style.display = row.innerText.toLowerCase().includes(val) ? '' : 'none';
    });
});
</script>

</body>
</html>