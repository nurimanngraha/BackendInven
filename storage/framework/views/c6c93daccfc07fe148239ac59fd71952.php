<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
<div class="bg-white p-8 rounded shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-bold text-center mb-6">Lupa Password</h2>

    <?php if(session('status')): ?>
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('password.email')); ?>">
        <?php echo csrf_field(); ?>
        <div class="mb-4">
            <label class="block font-semibold mb-1">Alamat Email</label>
            <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
        </div>

        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Kirim Link Reset</button>
    </form>

    <p class="text-center text-sm mt-4">
        <a href="<?php echo e(route('login')); ?>" class="text-blue-600 hover:underline">Kembali ke Login</a>
    </p>
</div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\BackendInven\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>