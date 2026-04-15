<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Manajemen Produk - Admin Spaghetti</title>
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <style>
        /* Reset & basic */
        body, html {
            margin: 0; padding: 0; height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f8;
        }
        /* Layout flex: sidebar + content */
        .wrapper {
            display: flex;
            min-height: 100vh;
        }
        /* Sidebar style */
        .sidebar {
            width: 250px;
            background: #0d6efd;
            color: white;
            display: flex;
            flex-direction: column;
            padding: 20px 15px;
        }
        .sidebar h4 {
            font-weight: 700;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1.3rem;
        }
        .sidebar h4 i {
            font-size: 1.5rem;
        }
        .nav {
            list-style: none;
            padding-left: 0;
            margin: 0;
            flex-grow: 1;
        }
        .nav-item {
            margin-bottom: 1rem;
        }
        .nav-link {
            color: #cfe2ff;
            text-decoration: none;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }
        .nav-link i {
            font-size: 1.2rem;
        }
        .nav-link:hover {
            background-color: #0b5ed7;
            color: white;
        }
        .nav-link.active {
            background-color: #084298;
            color: white;
            font-weight: 600;
        }
        /* Main content */
        .content {
            flex-grow: 1;
            padding: 30px 40px;
            background: white;
            border-radius: 0 8px 8px 0;
            box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
            max-width: 100%;
            overflow-x: auto;
        }
        h1 {
            margin-top: 0;
            color: #333;
            margin-bottom: 30px;
        }
        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            min-width: 700px;
        }
        thead tr {
            background-color: #0d6efd;
            color: white;
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            vertical-align: middle;
        }
        tbody tr:hover {
            background-color: #f1faff;
        }
        img.product-img {
            width: 60px;
            height: 40px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
            font-size: 0.9rem;
            transition: background-color 0.3s ease;
        }
        .btn-edit {
            background-color: #198754;
            margin-right: 6px;
        }
        .btn-edit:hover {
            background-color: #157347;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-delete:hover {
            background-color: #bb2d3b;
        }

        /* Responsive: sidebar collapse on small screens */
        @media (max-width: 768px) {
            .wrapper {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                border-radius: 0 0 8px 8px;
                padding: 15px 20px;
            }
            .content {
                border-radius: 0 0 8px 8px;
                padding: 20px;
            }
            table {
                min-width: unset;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav class="sidebar d-flex flex-column">
            <div class="mb-4">
                <h4 class="fw-bold">
                    <i class="bi bi-speedometer2"></i> Admin Spaghetti
                </h4>
            </div>
            <ul class="nav flex-column mb-auto">
                <li class="nav-item mb-2">
                    <a href="#" class="nav-link">
                        <i class="bi bi-house-door"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="/kelola-produk" class="nav-link active">
                        <i class="bi bi-box-seam"></i> Kelola Produk
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="/kelola-akun-kasir" class="nav-link">
                        <i class="bi bi-people"></i> Kelola Akun Kasir
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="/pantau-transaksi" class="nav-link">
                        <i class="bi bi-receipt"></i> Pantau Transaksi
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="/laporan-admin" class="nav-link">
                        <i class="bi bi-clipboard-data"></i> Laporan
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main content -->
        <main class="content">
            <h1>Manajemen Produk</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Contoh Produk A</td>
                        <td>Rp 50.000</td>
                        <td>20</td>
                        <td><img src="https://via.placeholder.com/60x40" alt="Produk A" class="product-img" /></td>
                        <td>
                            <button class="btn btn-edit">Edit</button>
                            <button class="btn btn-delete">Hapus</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Produk B</td>
                        <td>Rp 75.000</td>
                        <td>10</td>
                        <td><img src="https://via.placeholder.com/60x40" alt="Produk B" class="product-img" /></td>
                        <td>
                            <button class="btn btn-edit">Edit</button>
                            <button class="btn btn-delete">Hapus</button>
                        </td>
                    </tr>
                    <!-- Produk lainnya -->
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>
