<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\AdminKasirController;
use App\Http\Controllers\KasirLoginController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KelolaAkunKasirController;
use App\Http\Controllers\TransaksiController;


// Static views sementara
Route::view('/konfirmasi', 'konfirmasi');
Route::view('/laporan-admin', 'laporan-admin');
Route::view('/order', 'order');
Route::view('/kasir', 'kasir');
Route::view('/pantau-transaksi', 'pantau-transaksi');
Route::view('/transaksi-kasir', 'transaksi-kasir');
Route::view('/kelola-akun-kasir', 'kelola-akun-kasir');
Route::view('/produk', 'produk');
Route::view('/kelola-kasir', 'kelola-kasir');

// Halaman utama
Route::get('/index', fn () => view('index'))->name('home');

// Login user
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Login admin
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Dashboard
Route::get('/admin/dashboard', function () {
    if (!session('admin_logged_in')) {
        return redirect()->route('admin.login');
    }
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// Profil
Route::get('/profil', [ProfilController::class, 'index'])->middleware('auth')->name('profil');

// PESANAN - simpan pesanan
Route::post('/simpan-pesanan', [PesananController::class, 'simpan'])->name('pesanan.simpan');

// KASIR (kelola pesanan dari kasir)
Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
Route::post('/kasir', [KasirController::class, 'store'])->name('kasir.store');
Route::post('/kasir/update', [KasirController::class, 'update'])->name('kasir.update');
Route::post('/kasir/delete', [KasirController::class, 'delete'])->name('kasir.delete');

// Login Kasir
Route::get('/kasir/login', fn () => view('kasir.login'))->name('kasir.login');
Route::post('/kasir/login', [KasirLoginController::class, 'login'])->name('kasir.login.submit');

// Dashboard Kasir (session manual)
Route::get('/dashboardkasir', function () {
    if (!session()->has('username')) {
        return redirect('/login');
    }
    return view('dashboardkasir', ['username' => session('username')]);
})->name('dashboard.kasir');

// Manajemen Kasir
Route::get('/manajemen-kasir', [AdminKasirController::class, 'index'])->name('admin.kasir');
Route::post('/manajemen-kasir', [AdminKasirController::class, 'store'])->name('admin.kasir.store');
Route::delete('/manajemen-kasir/{id}', [AdminKasirController::class, 'destroy'])->name('admin.kasir.destroy');

Route::get('/admin/produk', [ProdukController::class, 'index'])->name('produk.index');

Route::post('/admin/produk/store', [ProdukController::class, 'store'])->name('produk.store');
// Test/debug
Route::get('/generate-hash/{password}', fn ($password) => bcrypt($password));
Route::get('/halaman', fn () => view('halaman', ['idPelanggan' => 123]));


Route::put('/produk/update/{id}', [ProdukController::class, 'update'])->name('produk.update');

Route::post('/pesanan/simpan', [PesananController::class, 'simpan'])
    ->name('pesanan.simpan');

Route::get('/order', [PesananController::class, 'order'])
    ->name('order');




use App\Http\Controllers\AuthKasirController;

Route::get('/login', [AuthKasirController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthKasirController::class, 'login'])->name('login.proses');
Route::get('/logout', [AuthKasirController::class, 'logout'])->name('logout');

Route::get('/', [AuthKasirController::class, 'index'])->name('index');


Route::get('/logout', [AuthKasirController::class, 'logout'])->name('logout');



Route::post('/pesanan/simpan', [PesananController::class, 'simpan'])
    ->name('pesanan.simpan');

Route::get('/order/{id}', [PesananController::class, 'order'])
    ->name('order.show');

Route::post('/pesanan/simpan', [PesananController::class, 'simpan'])
    ->name('pesanan.simpan');


Route::post('/simpan-pesanan', [PesananController::class,'simpan'])->name('simpan.pesanan');

Route::get('/order', [PesananController::class,'order'])->name('order');




Route::get('/kasir', [KasirController::class,'index'])->name('kasir');

Route::get('/order', [PesananController::class,'order'])->name('order');

Route::post('/simpan-pesanan', [PesananController::class,'simpan'])->name('simpan.pesanan');



use App\Http\Controllers\CashierController;

Route::get('/order', [PesananController::class,'order'])->name('order');

Route::post('/simpan-pesanan', [PesananController::class,'simpan'])->name('simpan.pesanan');

Route::get('/kasir', [CashierController::class,'index'])->name('kasir');





use App\Http\Controllers\AdminDashboardController;

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/dashboard/data', [AdminDashboardController::class, 'data'])->name('admin.dashboard.data');
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');


use App\Http\Controllers\LogActivityController;

Route::get('/log-activity', [LogActivityController::class, 'index'])
    ->name('admin.log');
Route::get('/admin/laporan', [AdminController::class, 'laporan'])->name('admin.laporan');

Route::post('/admin/produk', [ProdukController::class, 'store'])->name('produk.store');
Route::put('/admin/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');




use App\Htp\Controllers\AuthenticatedSessionController;

// HALAMAN LOGIN
Route::get('/login', function () {
    return view('login'); // sesuai punyamu
})->name('login');

// LOGOUT
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

Route::get('/admin/laporan', function () {
    return view('admin.laporan');
});


Route::get('/riwayat', function () {
    return view('riwayat'); // ⬅️ sesuai punyamu
})->name('riwayat');



use Illuminate\Http\Request;

Route::post('/konfirmasi', function (Request $request) {

    // ambil data lama
    $riwayat = session()->get('riwayat', []);

    // tambah data baru
    $riwayat[] = [
        'kode' => 'TRX' . str_pad(count($riwayat)+1, 3, '0', STR_PAD_LEFT),
        'tanggal' => now()->format('Y-m-d'),
        'pelanggan' => $request->id_pelanggan,
        'total' => $request->total_harga
    ];

    // simpan lagi ke session
    session(['riwayat' => $riwayat]);

    return redirect()->route('riwayat');
})->name('konfirmasi');


Route::get('/riwayat', function () {

    $data = session('riwayat', []);

    return view('riwayat', compact('data'));

})->name('riwayat');



Route::post('/simpan-transaksi', [KasirController::class, 'simpan'])->name('simpan.transaksi');
Route::get('/riwayat', [KasirController::class, 'riwayat'])->name('riwayat');

Route::get('/admin/laporan', [AdminController::class, 'laporan']);

Route::get('/admin/laporan', [AdminController::class, 'laporan'])->name('admin.laporan');



Route::get('/kelola-akun-kasir', [KelolaAkunKasirController::class, 'index']);
Route::post('/kasir/simpan', [KelolaAkunKasirController::class, 'store'])->name('kasir.simpan');
Route::get('/kasir/hapus/{id}', [KelolaAkunKasirController::class, 'delete'])->name('kasir.hapus');



Route::get('/kasir', [CashierController::class, 'index'])->name('kasir');
Route::get('/kasir/edit/{id}', [CashierController::class, 'edit'])->name('admin.kasir.edit');

Route::get('/admin', [AdminController::class, 'index']);



Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/laporan', [AdminController::class, 'laporan'])->name('admin.laporan');

// Gunakan sintaks yang benar (cara yang direkomendasikan)
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// Atau jika menggunakan string (Laravel 8+ perlu namespace lengkap)
Route::get('/admin/dashboard', 'App\Http\Controllers\AdminController@dashboard')->name('admin.dashboard');



use App\Http\Controllers\LaporanController;

Route::get('/admin/laporan', [LaporanController::class, 'laporan'])->name('admin.laporan');
Route::get('/admin/dashboard', [LaporanController::class, 'dashboard'])->name('admin.dashboard');


use App\Http\Controllers\OrderController;

// Route untuk menampilkan detail order
Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.detail');

// Route halaman kasir (untuk tombol konfirmasi)
Route::get('/kasir', function() {
    return view('kasir'); // Buat file resources/views/kasir.blade.php
})->name('kasir');



Route::get('/struk', function() {
    return view('struk');
})->name('struk');


Route::get('/kasir', function () {
    return view('kasir');
})->name('kasir');

Route::get('/riwayat', function () {
    return view('riwayat');
})->name('riwayat');

Route::get('/logout', function () {
    return redirect('/');
})->name('logout');


Route::get('/struk', function () {
    return view('struk');
})->name('struk');


Route::get('/riwayat', function () {
    return view('riwayat');
})->name('riwayat');

Route::get('/struk-cetak', function () {
    return view('struk_cetak');
})->name('struk_cetak');


// Route untuk halaman struk
Route::get('/struk-cetak', function () {
    return view('struk_cetak');
})->name('struk_cetak');

// Atau jika menggunakan URL yang berbeda, sesuaikan
// Route::get('/sryuk', function () {
//     return view('struk_cetak');
// })->name('struk_cetak');



Route::get('/kasir', function () {
    return view('kasir');
})->name('kasir');

Route::get('/pembayaran', function () {
    return view('struk');
})->name('pembayaran');

Route::get('/riwayat', function () {
    return view('riwayat');
})->name('riwayat');

Route::get('/struk-cetak', function () {
    return view('struk_cetak');
})->name('struk');

// Tambahkan ini di bagian atas atau bawah file (cukup sekali)
Route::get('/', function () {
    return view('index'); // Sesuaikan dengan nama file blade Anda
})->name('index');

// Route untuk store produk (tambah produk)
Route::post('/admin/produk', function (Request $request) {
    try {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle upload gambar
        $gambarPath = null;
        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            $file = $request->file('gambar');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $gambarPath = $file->storeAs('gambar_produk', $filename, 'public');
        }

        // Simpan ke database
        $produk = Produk::create([
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'gambar' => $gambarPath,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        if ($produk) {
            return redirect()->route('admin.produk')->with('success', 'Produk "' . $request->nama . '" berhasil ditambahkan!');
        } else {
            return redirect()->route('admin.produk')->with('error', 'Gagal menyimpan produk!');
        }
        
    } catch (\Exception $e) {
        return redirect()->route('admin.produk')->with('error', 'Error: ' . $e->getMessage());
    }
})->name('produk.store');


Route::get('/api/menu', function() {
    return response()->json(Produk::all());
});



Route::get('/riwayat', function () {
    $riwayat = [
        [
            'id' => 1,
            'tanggal' => '2024-03-20',
            'keterangan' => 'Pembelian produk A',
            'jumlah' => 2,
            'total' => 250000
        ],
        [
            'id' => 2,
            'tanggal' => '2024-03-19',
            'keterangan' => 'Pembelian produk B',
            'jumlah' => 1,
            'total' => 150000
        ]
    ];
    
    return view('riwayat', compact('riwayat'));
});

Route::get('/', function () {
    return redirect('/riwayat');
});


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route untuk halaman utama
Route::get('/', function () {
    return redirect()->route('riwayat');
});

// Route untuk riwayat
Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');

// Route untuk transaksi (ganti dari kasir)
Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi');
Route::post('/transaksi/process', [TransaksiController::class, 'processOrder'])->name('transaksi.process');

// Route untuk order
Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');




Route::get('/', function () {
    return redirect()->route('riwayat');
});

// Route untuk riwayat
Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
Route::post('/riwayat', [RiwayatController::class, 'store'])->name('riwayat.store');
Route::put('/riwayat/{id}', [RiwayatController::class, 'update'])->name('riwayat.update');
Route::delete('/riwayat/{id}', [RiwayatController::class, 'destroy'])->name('riwayat.destroy');
Route::get('/riwayat/clear', [RiwayatController::class, 'clear'])->name('riwayat.clear');
Route::get('/riwayat/add-sample', [RiwayatController::class, 'addSample'])->name('riwayat.addSample');





// ROUTE UNTUK INDEX / DASHBOARD
Route::get('/', [AuthKasirController::class, 'index'])->name('index');

// ROUTE UNTUK LOGOUT
Route::post('/logout', [AuthKasirController::class, 'logout'])->name('logout');




Route::get('/admin/produk', [ProdukController::class, 'index']);
Route::post('/produk/store', [ProdukController::class, 'store'])->name('produk.store');
Route::put('/admin/produk/{id}', [ProdukController::class, 'update']);
Route::delete('/admin/produk/{id}', [ProdukController::class, 'destroy']);

Route::post('/kasir/simpan', [KasirController::class, 'store'])->name('kasir.simpan');
Route::get('/kasir/hapus/{id}', [KasirController::class, 'destroy'])->name('kasir.hapus');
Route::post('/kasir/update/{id}', [KasirController::class, 'update'])->name('kasir.update');

Route::post('/kasir/update/{id}', [KasirController::class, 'update']);

Route::get('/api/produk', [ProdukController::class, 'list'])->name('api.produk.list');
Route::post('/admin/produk', [ProdukController::class, 'store'])->name('produk.store');
Route::delete('/admin/produk/{id}', [ProdukController::class, 'destroy']);

Route::get('/pembayaran', function () {
    return view('pembayaran');
})->name('pembayaran');

