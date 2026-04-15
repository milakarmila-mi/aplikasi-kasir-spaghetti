<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-orange-50 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm">
        <h2 class="text-2xl font-bold text-orange-600 mb-6 text-center">Login Admin</h2>

        <?php if(session('error')): ?>
            <p class="mb-4 text-center text-red-600 font-semibold"><?php echo e(session('error')); ?></p>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('admin.login.submit')); ?>" class="space-y-5">
            <?php echo csrf_field(); ?>
            <div>
                <label class="block text-orange-700 font-medium mb-1" for="username">Username:</label>
                <input id="username" type="text" name="username" required
                    class="w-full border border-orange-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400" />
            </div>

            <div>
                <label class="block text-orange-700 font-medium mb-1" for="password">Password:</label>
                <input id="password" type="password" name="password" required
                    class="w-full border border-orange-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400" />
            </div>

            <button type="submit"
                class="w-full bg-orange-600 hover:bg-orange-700 text-white font-semibold py-2 rounded transition">
                Login
            </button>
        </form>
    </div>
</body>
</html>
<?php /**PATH C:\xamppbaruu\htdocs\laravel\resources\views/admin/login.blade.php ENDPATH**/ ?>