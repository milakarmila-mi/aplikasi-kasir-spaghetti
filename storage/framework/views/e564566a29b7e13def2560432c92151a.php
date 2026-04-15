<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Kasir - Spaghetteria</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-8 rounded-lg shadow-lg w-96">
    <h2 class="text-2xl font-bold text-center text-red-600 mb-6">
        🍝 Login Kasir Spaghetteria
    </h2>

    <?php if(session('error')): ?>
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4 text-center">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('login.proses')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Username</label>
            <input type="text" name="username"
                   class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400"
                   required>
        </div>

        <div class="mb-6">
            <label class="block font-semibold mb-1">Password</label>
            <input type="password" name="password"
                   class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-400"
                   required>
        </div>

        <button type="submit"
                class="w-full bg-red-500 text-white py-2 rounded-lg font-bold hover:bg-red-600 transition duration-200">
            Login
        </button>
    </form>
</div>

</body>
</html>

<?php
/**
 * ============================================
 * LARAVEL BACKEND INTEGRATION CODE
 * ============================================
 * 
 * Untuk menghubungkan login dengan halaman kasir, Anda perlu menambahkan kode berikut
 * ke dalam file-file Laravel Anda:
 * 
 * 1. ROUTES (routes/web.php):
 * 
 * Route::get('/', function () {
 *     return view('auth.login');
 * })->name('login');
 * 
 * Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
 * Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
 * 
 * Route::middleware(['auth'])->group(function () {
 *     Route::get('/dashboard', [KasirController::class, 'index'])->name('dashboard');
 *     Route::post('/pesanan/simpan', [PesananController::class, 'simpan'])->name('pesanan.simpan');
 * });
 * 
 * 
 * 2. CONTROLLER (app/Http/Controllers/AuthController.php):
 * 
 * <?php
 * namespace App\Http\Controllers;
 * 
 * use Illuminate\Http\Request;
 * use Illuminate\Support\Facades\Auth;
 * 
 * class AuthController extends Controller
 * {
 *     public function login(Request $request)
 *     {
 *         $credentials = $request->validate([
 *             'username' => 'required',
 *             'password' => 'required',
 *         ]);
 * 
 *         if (Auth::attempt($credentials)) {
 *             $request->session()->regenerate();
 *             return redirect()->intended('/dashboard');
 *         }
 * 
 *         return back()->with('error', 'Username atau password salah!');
 *     }
 * 
 *     public function logout(Request $request)
 *     {
 *         Auth::logout();
 *         $request->session()->invalidate();
 *         $request->session()->regenerateToken();
 *         return redirect('/');
 *     }
 * }
 * 
 * 
 * 3. CONTROLLER (app/Http/Controllers/KasirController.php):
 * 
 * <?php
 * namespace App\Http\Controllers;
 * 
 * use Illuminate\Http\Request;
 * use App\Models\Menu;
 * 
 * class KasirController extends Controller
 * {
 *     public function index()
 *     {
 *         $menus = Menu::where('stok', '>', 0)->orderBy('nama')->get();
 *         return view('kasir.dashboard', compact('menus'));
 *     }
 * }
 * 
 * 
 * 4. CONTROLLER (app/Http/Controllers/PesananController.php):
 * 
 * <?php
 * namespace App\Http\Controllers;
 * 
 * use Illuminate\Http\Request;
 * use App\Models\Pesanan;
 * use App\Models\DetailPesanan;
 * use App\Models\Menu;
 * use Illuminate\Support\Facades\DB;
 * 
 * class PesananController extends Controller
 * {
 *     public function simpan(Request $request)
 *     {
 *         $validated = $request->validate([
 *             'id_pelanggan' => 'required',
 *             'detail' => 'required|array',
 *             'total_harga' => 'required|numeric',
 *             'tipe_layanan' => 'required|in:Dine In,Take Away'
 *         ]);
 * 
 *         try {
 *             DB::beginTransaction();
 * 
 *             // Simpan pesanan
 *             $pesanan = Pesanan::create([
 *                 'id_pelanggan' => $validated['id_pelanggan'],
 *                 'tanggal' => now(),
 *                 'total_harga' => $validated['total_harga'],
 *                 'tipe_layanan' => $validated['tipe_layanan'],
 *                 'status' => 'pending'
 *             ]);
 * 
 *             // Simpan detail dan kurangi stok
 *             foreach ($validated['detail'] as $item) {
 *                 $menu = Menu::where('nama', $item['nama'])->first();
 *                 
 *                 if ($menu && $menu->stok >= $item['jumlah']) {
 *                     DetailPesanan::create([
 *                         'id_pesanan' => $pesanan->id,
 *                         'id_menu' => $menu->id,
 *                         'jumlah' => $item['jumlah'],
 *                         'harga' => $item['harga']
 *                     ]);
 *                     
 *                     $menu->decrement('stok', $item['jumlah']);
 *                 } else {
 *                     throw new \Exception("Stok {$item['nama']} tidak mencukupi");
 *                 }
 *             }
 * 
 *             DB::commit();
 * 
 *             return response()->json([
 *                 'success' => true,
 *                 'redirect' => route('dashboard'),
 *                 'message' => 'Pesanan berhasil disimpan!'
 *             ]);
 * 
 *         } catch (\Exception $e) {
 *             DB::rollBack();
 *             return response()->json([
 *                 'success' => false,
 *                 'message' => 'Gagal menyimpan pesanan: ' . $e->getMessage()
 *             ], 500);
 *         }
 *     }
 * }
 * 
 * 
 * 5. MODEL (app/Models/Menu.php):
 * 
 * <?php
 * namespace App\Models;
 * 
 * use Illuminate\Database\Eloquent\Model;
 * 
 * class Menu extends Model
 * {
 *     protected $fillable = ['nama', 'harga', 'stok', 'gambar'];
 * }
 * 
 * 
 * 6. MODEL (app/Models/Pesanan.php):
 * 
 * <?php
 * namespace App\Models;
 * 
 * use Illuminate\Database\Eloquent\Model;
 * 
 * class Pesanan extends Model
 * {
 *     protected $fillable = ['id_pelanggan', 'tanggal', 'total_harga', 'tipe_layanan', 'status'];
 * }
 * 
 * 
 * 7. MODEL (app/Models/DetailPesanan.php):
 * 
 * <?php
 * namespace App\Models;
 * 
 * use Illuminate\Database\Eloquent\Model;
 * 
 * class DetailPesanan extends Model
 * {
 *     protected $fillable = ['id_pesanan', 'id_menu', 'jumlah', 'harga'];
 * }
 * 
 * 
 * 8. SEEDER (database/seeders/MenuSeeder.php):
 * 
 * <?php
 * namespace Database\Seeders;
 * 
 * use Illuminate\Database\Seeder;
 * use App\Models\Menu;
 * 
 * class MenuSeeder extends Seeder
 * {
 *     public function run()
 *     {
 *         Menu::create([
 *             'nama' => 'Spaghetti Carbonara',
 *             'harga' => 45000,
 *             'stok' => 20,
 *             'gambar' => '/images/carbonara.jpg'
 *         ]);
 *         
 *         Menu::create([
 *             'nama' => 'Spaghetti Aglio Olio',
 *             'harga' => 40000,
 *             'stok' => 15,
 *             'gambar' => '/images/aglio-olio.jpg'
 *         ]);
 *         
 *         Menu::create([
 *             'nama' => 'Fettucine Alfredo',
 *             'harga' => 50000,
 *             'stok' => 12,
 *             'gambar' => '/images/alfredo.jpg'
 *         ]);
 *         
 *         Menu::create([
 *             'nama' => 'Lasagna Bolognese',
 *             'harga' => 55000,
 *             'stok' => 10,
 *             'gambar' => '/images/lasagna.jpg'
 *         ]);
 *         
 *         Menu::create([
 *             'nama' => 'Penne Arabiata',
 *             'harga' => 42000,
 *             'stok' => 18,
 *             'gambar' => '/images/arabiata.jpg'
 *         ]);
 *     }
 * }
 * 
 * 
 * 9. MIGRATION (database/migrations/2024_01_01_000000_create_menus_table.php):
 * 
 * <?php
 * use Illuminate\Database\Migrations\Migration;
 * use Illuminate\Database\Schema\Blueprint;
 * use Illuminate\Support\Facades\Schema;
 * 
 * return new class extends Migration
 * {
 *     public function up()
 *     {
 *         Schema::create('menus', function (Blueprint $table) {
 *             $table->id();
 *             $table->string('nama');
 *             $table->integer('harga');
 *             $table->integer('stok');
 *             $table->string('gambar');
 *             $table->timestamps();
 *         });
 * 
 *         Schema::create('pesanans', function (Blueprint $table) {
 *             $table->id();
 *             $table->string('id_pelanggan');
 *             $table->datetime('tanggal');
 *             $table->integer('total_harga');
 *             $table->enum('tipe_layanan', ['Dine In', 'Take Away']);
 *             $table->enum('status', ['pending', 'proses', 'selesai'])->default('pending');
 *             $table->timestamps();
 *         });
 * 
 *         Schema::create('detail_pesanans', function (Blueprint $table) {
 *             $table->id();
 *             $table->foreignId('id_pesanan')->constrained()->onDelete('cascade');
 *             $table->foreignId('id_menu')->constrained()->onDelete('cascade');
 *             $table->integer('jumlah');
 *             $table->integer('harga');
 *             $table->timestamps();
 *         });
 *     }
 * 
 *     public function down()
 *     {
 *         Schema::dropIfExists('detail_pesanans');
 *         Schema::dropIfExists('pesanans');
 *         Schema::dropIfExists('menus');
 *     }
 * };
 * 
 * 
 * 10. CREATE USERS TABLE MIGRATION (jika belum ada):
 * 
 * <?php
 * use Illuminate\Database\Migrations\Migration;
 * use Illuminate\Database\Schema\Blueprint;
 * use Illuminate\Support\Facades\Schema;
 * 
 * return new class extends Migration
 * {
 *     public function up()
 *     {
 *         Schema::create('users', function (Blueprint $table) {
 *             $table->id();
 *             $table->string('username')->unique();
 *             $table->string('password');
 *             $table->string('name');
 *             $table->timestamps();
 *         });
 *     }
 * 
 *     public function down()
 *     {
 *         Schema::dropIfExists('users');
 *     }
 * };
 * 
 * 
 * 11. SEEDER USER (database/seeders/UserSeeder.php):
 * 
 * <?php
 * namespace Database\Seeders;
 * 
 * use Illuminate\Database\Seeder;
 * use Illuminate\Support\Facades\Hash;
 * use App\Models\User;
 * 
 * class UserSeeder extends Seeder
 * {
 *     public function run()
 *     {
 *         User::create([
 *             'username' => 'kasir',
 *             'password' => Hash::make('123456'),
 *             'name' => 'Kasir Spaghetteria'
 *         ]);
 *     }
 * }
 * 
 * 
 * 12. VIEW KASIR (resources/views/kasir/dashboard.blade.php):
 * 
 * (Ini adalah halaman dashboard kasir yang sudah Anda miliki di atas)
 * 
 * 
 * 13. UPDATE .env (pastikan database terkonfigurasi):
 * 
 * DB_CONNECTION=mysql
 * DB_HOST=127.0.0.1
 * DB_PORT=3306
 * DB_DATABASE=spaghetteria
 * DB_USERNAME=root
 * DB_PASSWORD=
 * 
 * 
 * 14. RUN COMMANDS:
 * 
 * php artisan migrate
 * php artisan db:seed --class=UserSeeder
 * php artisan db:seed --class=MenuSeeder
 * php artisan serve
 * 
 * 
 * ============================================
 * LOGIN CREDENTIALS:
 * Username: kasir
 * Password: 123456
 * ============================================
 */
?>

<!-- 
    ============================================
    FILE LENGKAP DASHBOARD KASIR
    Simpan sebagai: resources/views/kasir/dashboard.blade.php
    ============================================
-->
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Kasir - Spaghetteria</title>

<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
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
    <form action="<?php echo e(route('logout')); ?>" method="POST">
        <?php echo csrf_field(); ?>
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

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

<?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<?php
$safeNama = preg_replace('/[^A-Za-z0-9]/','_',$menu->nama);
?>

<div class="bg-white p-4 rounded-xl shadow-lg text-center hover:scale-105 transition">

<img src="<?php echo e(asset($menu->gambar)); ?>" class="w-full h-48 object-cover rounded-lg" alt="<?php echo e($menu->nama); ?>">

<h2 class="text-xl font-bold mt-2">
<?php echo e($menu->nama); ?>

</h2>

<p class="text-gray-800 font-semibold text-lg">
Rp<?php echo e(number_format($menu->harga,0,',','.')); ?>

</p>

<p class="text-sm font-semibold 
<?php echo e($menu->stok <= 5 ? 'text-red-500' : 'text-green-600'); ?>">
Stok: <span id="stok-<?php echo e($safeNama); ?>"><?php echo e($menu->stok); ?></span>
</p>

<div class="flex justify-between mt-4 items-center">

<button
onclick="kurangiJumlah('<?php echo e($safeNama); ?>')"
class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
-
</button>

<span class="jumlah text-lg font-bold" id="jumlah-<?php echo e($safeNama); ?>">
0
</span>

<button
onclick="tambahJumlah('<?php echo e($safeNama); ?>', <?php echo e($menu->harga); ?>, '<?php echo e(addslashes($menu->nama)); ?>', <?php echo e($menu->stok); ?>)"
class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition
<?php echo e($menu->stok <= 0 ? 'opacity-50 cursor-not-allowed' : ''); ?>"
<?php echo e($menu->stok <= 0 ? 'disabled' : ''); ?>>
+
</button>

</div>

</div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>

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

    document.getElementById("jumlah-"+safeNama).innerText = keranjang[nama].jumlah
    document.getElementById("stok-"+safeNama).innerText = stok - keranjang[nama].jumlah

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
                document.getElementById("jumlah-"+safeNama).innerText = keranjang[nama].jumlah
                document.getElementById("stok-"+safeNama).innerText = keranjang[nama].stok - keranjang[nama].jumlah
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
    list.innerHTML=""

    let total = 0

    for(const nama in keranjang)
    {
        const item = keranjang[nama]

        if(item.jumlah > 0)
        {
            let li = document.createElement("li")
            li.className = "flex justify-between items-center border-b pb-2"
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

    document.getElementById("totalHarga").innerHTML = "Rp"+total.toLocaleString("id-ID")
}

// SIMPAN
function konfirmasiPesanan()
{
    const idPelanggan = document.getElementById("idPelangganValue").innerText

    const tipeLayanan =
    document.querySelector('input[name="tipeLayanan"]:checked').value

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

    fetch("<?php echo e(route('pesanan.simpan')); ?>",{
        method:"POST",
        headers:{
            "Content-Type":"application/json",
            "X-CSRF-TOKEN":
            document.querySelector('meta[name="csrf-token"]').content
        },
        body:JSON.stringify({
            id_pelanggan:idPelanggan,
            detail:detail,
            total_harga:total,
            tipe_layanan:tipeLayanan
        })
    })
    .then(res=>res.json())
    .then(data=>{
        if(data.redirect)
        {
            // Reset keranjang setelah sukses
            for(const nama in keranjang) {
                const safeNama = nama.replace(/[^A-Za-z0-9]/g,'_')
                const stokElem = document.getElementById("stok-"+safeNama)
                if(stokElem) {
                    const newStok = keranjang[nama].stok - keranjang[nama].jumlah
                    stokElem.innerText = newStok
                }
                const jumlahElem = document.getElementById("jumlah-"+safeNama)
                if(jumlahElem) {
                    jumlahElem.innerText = "0"
                }
            }
            // Kosongkan keranjang object
            for(const nama in keranjang) {
                delete keranjang[nama]
            }
            updateKeranjang()
            
            alert("✅ Pesanan berhasil disimpan!")
            window.location.href = data.redirect
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
</html><?php /**PATH C:\xamppbaruu\htdocs\laravel\resources\views/kasir/login.blade.php ENDPATH**/ ?>