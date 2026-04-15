<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kelola Kasir</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    background:#f4f7fc;
}

/* SIDEBAR */
.sidebar {
    width:260px;
    background: linear-gradient(180deg,#ff7a00,#ff3d00);
    color:white;
    min-height:100vh;
    padding:20px;
}

.sidebar h4 {
    margin-bottom:20px;
}

/* MENU LIST */
.sidebar ul {
    list-style:none;
    padding:0;
}

.sidebar ul li {
    margin-bottom:8px;
}

.sidebar ul li a {
    color:white;
    text-decoration:none;
    display:block;
    padding:10px;
    border-radius:8px;
    transition:0.3s;
}

.sidebar ul li a:hover {
    background:rgba(255,255,255,0.2);
}

.sidebar ul li a.active {
    background:rgba(255,255,255,0.3);
    font-weight:bold;
}

.admin-wrapper {
    display:flex;
}

.main-content {
    flex:1;
    padding:30px;
}

/* TABLE WITH ORANGE THEME */
.table {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.table thead th {
    background: #ff7a00 !important;
    color: white !important;
    border-bottom: none;
    font-weight: 600;
    text-align: center;
    vertical-align: middle;
}

.table tbody tr:hover {
    background-color: #fff3e6 !important;
}

.table td, .table th {
    vertical-align: middle;
    text-align: center;
}

/* BUTTON ORANGE */
.btn-warning {
    background: #ff7a00;
    border-color: #ff7a00;
    color: white;
}

.btn-warning:hover {
    background: #e66a00;
    border-color: #e66a00;
    color: white;
}

.btn-success {
    background: #ff7a00;
    border-color: #ff7a00;
}

.btn-success:hover {
    background: #e66a00;
    border-color: #e66a00;
}

/* MODAL HEADER ORANGE */
.modal-header {
    background: #ff7a00;
    color: white;
}

.modal-header .btn-close {
    filter: brightness(0) invert(1);
}

.btn-primary {
    background: #ff7a00;
    border-color: #ff7a00;
}

.btn-primary:hover {
    background: #e66a00;
    border-color: #e66a00;
}
</style>
</head>

<body>

<div class="admin-wrapper">

<!-- SIDEBAR -->
<div class="sidebar">
    <h4>🍝 Admin Spaghetti</h4>

    <ul>
        <li><a href="/admin/dashboard"><i class="bi bi-house"></i> Dashboard</a></li>
        <li><a href="/admin/produk"><i class="bi bi-box"></i> Kelola Produk</a></li>
        <li><a href="/kelola-akun-kasir" class="active"><i class="bi bi-people"></i> Kelola Kasir</a></li>
        <li><a href="/pantau-transaksi"><i class="bi bi-graph-up"></i> Pantau Transaksi</a></li>
        <li><a href="/log-activity"><i class="bi bi-clock-history"></i> Log Activity</a></li>
        <li><a href="/admin/laporan"><i class="bi bi-file-earmark-text"></i> Laporan</a></li>
    </ul>
</div>

<!-- CONTENT -->
<div class="main-content">

<div class="d-flex justify-content-between mb-3">
    <h3><i class="bi bi-people-fill" style="color:#ff7a00;"></i> Kelola Kasir</h3>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-circle"></i> Tambah Kasir
    </button>
</div>

<?php if(session('success')): ?>
<div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<?php if(session('error')): ?>
<div class="alert alert-danger"><?php echo e(session('error')); ?></div>
<?php endif; ?>

<table class="table table-bordered table-hover">
<thead>
<tr>
<th>No</th>
<th>Username</th>
<th>Password</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>
<?php $__currentLoopData = $kasir; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
<td><?php echo e($i+1); ?></td>
<td><?php echo e($k->username); ?></td>
<td>******</td>
<td>
<button class="btn btn-warning btn-sm"
onclick="editKasir('<?php echo e($k->id); ?>','<?php echo e($k->username); ?>','<?php echo e($k->password); ?>')">
<i class="bi bi-pencil"></i> Edit
</button>

<a href="<?php echo e(route('kasir.hapus',$k->id)); ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Hapus akun kasir ini?')">
<i class="bi bi-trash"></i> Hapus
</a>
</td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
</table>

</div>
</div>

<!-- MODAL TAMBAH -->
<div class="modal fade" id="modalTambah">
<div class="modal-dialog">
<form method="POST" action="<?php echo e(route('kasir.simpan')); ?>" class="modal-content">
<?php echo csrf_field(); ?>

<div class="modal-header">
<h5><i class="bi bi-person-plus-fill"></i> Tambah Kasir</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
<input type="text" name="password" class="form-control" placeholder="Password" required>
</div>

<div class="modal-footer">
<button class="btn btn-primary">Simpan</button>
</div>

</form>
</div>
</div>

<!-- MODAL EDIT -->
<div class="modal fade" id="modalEdit">
<div class="modal-dialog">
<form id="formEdit" method="POST" class="modal-content">
<?php echo csrf_field(); ?>

<div class="modal-header">
<h5><i class="bi bi-pencil-square"></i> Edit Kasir</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<input type="hidden" id="edit_id">
<input type="text" id="edit_username" name="username" class="form-control mb-2" required>
<input type="text" id="edit_password" name="password" class="form-control" required>
</div>

<div class="modal-footer">
<button class="btn btn-warning">Update</button>
</div>

</form>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function editKasir(id, username, password)
{
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_username').value = username;
    document.getElementById('edit_password').value = password;

    document.getElementById('formEdit').action = "/kasir/update/" + id;

    var modal = new bootstrap.Modal(document.getElementById('modalEdit'));
    modal.show();
}
</script>

</body>
</html><?php /**PATH C:\xamppbaruu\htdocs\laravel\resources\views/kelola-akun-kasir.blade.php ENDPATH**/ ?>