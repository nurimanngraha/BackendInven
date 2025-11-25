<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Akun Berhasil Dibuat</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f3f4f6; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 10px;">
        <h2 style="color: #16a34a;">Halo <?php echo e($user->name); ?> 👋</h2>
        <p>Akun Anda di <strong>BackendInven</strong> telah berhasil dibuat.</p>
        <p>Email Anda: <strong><?php echo e($user->email); ?></strong></p>
        <p>Terima kasih telah bergabung bersama kami!</p>
        <a href="<?php echo e(route('login')); ?>"
        style="display:inline-block; background-color:#16a34a; color:white; padding:10px 15px; border-radius:5px; text-decoration:none; font-weight:bold;">
        Login Sekarang
        </a>

        <p style="margin-top: 20px;">Salam hangat,<br><strong>Tim BackendInven</strong></p>
    </div>
</body>
</html>

<?php /**PATH C:\xampp\htdocs\BackendInven\resources\views/emails/account-created.blade.php ENDPATH**/ ?>