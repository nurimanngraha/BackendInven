<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Laravel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center h-screen">

    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
        <h1 class="text-xl font-semibold text-center text-gray-800 mb-2">Laravel</h1>
        <h2 class="text-2xl font-bold text-center mb-6">Sign in</h2>

        @if (session('success'))
            <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded">
                 {{ session('success') }}
            </div>
        @endif


        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                <input type="email" name="email" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>

            <div class="mb-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>

            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center">
                    <input id="remember" type="checkbox" name="remember" class="h-4 w-4 text-orange-600 border-gray-300 rounded">
                    <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
                </div>
                <div>
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">
                        Lupa password?
                    </a>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded">
                Sign in
            </button>
        </form>

        <p class="text-center text-sm mt-4">
            Belum punya akun?
            <a href="{{ route('register.form') }}" class="text-blue-600 hover:underline">Daftar di sini</a>
        </p>
    </div>

</body>
</html>

