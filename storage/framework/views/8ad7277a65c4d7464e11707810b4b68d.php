<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Kasir</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-8 rounded-lg shadow-lg w-96">
    <h2 class="text-2xl font-bold text-center text-red-600 mb-6">
         Login Kasir 
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
                   class="w-full border rounded-lg px-3 py-2"
                   required>
        </div>

        <div class="mb-6">
            <label class="block font-semibold mb-1">Password</label>
            <input type="password" name="password"
                   class="w-full border rounded-lg px-3 py-2"
                   required>
        </div>

        <button type="submit"
                class="w-full bg-red-500 text-white py-2 rounded-lg font-bold hover:bg-red-600">
            Login
        </button>
    </form>
</div>

</body>
</html><?php /**PATH C:\xamppbaruu\htdocs\laravel\resources\views/login.blade.php ENDPATH**/ ?>