<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-100 to-blue-100 min-h-screen flex items-center justify-center">
<div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
    
    {{-- Pesan sukses jika password berhasil direset --}}
    @if (session('success'))
        <div class="mb-4 p-3 text-green-800 bg-green-100 border border-green-300 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Pesan error jika ada masalah --}}
    @if ($errors->any())
        <div class="mb-4 p-3 text-red-800 bg-red-100 border border-red-300 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Reset Password</h2>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        
        {{-- 🔒 Email otomatis terisi dari URL, tidak bisa diubah --}}
        <div class="mb-4">
            <input type="hidden" name="email" value="{{ $email }}">
            <p class="block font-semibold mb-1 text-gray-700">Email akun:</p>
            <div class="border border-gray-300 bg-gray-100 rounded-lg px-3 py-2 text-gray-800 font-semibold">
                {{ $email }}
            </div>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1 text-gray-700">Password Baru</label>
            <input type="password" name="password" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" required>
        </div>

        <div class="mb-6">
            <label class="block font-semibold mb-1 text-gray-700">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none" required>
        </div>

        <button type="submit" class="w-full bg-green-600 text-white font-semibold py-2 rounded-lg hover:bg-green-700 transition duration-200">
            Simpan Password Baru
        </button>
    </form>

</div>
</body>
</html>
