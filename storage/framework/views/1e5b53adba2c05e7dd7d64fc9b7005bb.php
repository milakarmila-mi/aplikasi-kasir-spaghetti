<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<title>Detail Order</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-10">

<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">

<h1 class="text-2xl font-bold mb-4 text-red-600">Detail Pesanan</h1>

<p class="mb-2"><strong>ID Pelanggan:</strong> <?php echo e($order->id_pelanggan); ?></p>
<p class="mb-4"><strong>Total Harga:</strong> Rp<?php echo e(number_format($order->total_harga,0,',','.')); ?></p>

<h2 class="text-xl font-bold mt-4">Detail Menu</h2>

<ul class="list-disc ml-6 mt-2 mb-4">
<?php $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<li><?php echo e($item['nama']); ?> x <?php echo e($item['jumlah']); ?></li>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>

<div class="mt-6">
<button onclick="konfirmasiPesanan()" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
    Konfirmasi Pesanan
</button>
</div>

</div>

<script>
function konfirmasiPesanan() {
    // Data order yang akan dikirim ke halaman kasir
    const orderData = {
        id_pelanggan: "<?php echo e($order->id_pelanggan); ?>",
        total_harga: <?php echo e($order->total_harga); ?>,
        details: <?php echo json_encode($details, 15, 512) ?>,
        timestamp: new Date().toISOString(),
        waktu: new Date().toLocaleString('id-ID')
    };
    
    // Simpan data ke localStorage dengan key khusus
    localStorage.setItem('order_to_process', JSON.stringify(orderData));
    
    alert('✅ Pesanan siap diproses!\nMengalihkan ke halaman kasir...');
    
    // Redirect ke halaman kasir
    window.location.href = "<?php echo e(route('kasir')); ?>?auto=1";
}
</script>

</body>
</html><?php /**PATH C:\xamppbaruu\htdocs\laravel\resources\views/order.blade.php ENDPATH**/ ?>