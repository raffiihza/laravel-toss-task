<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduTend</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white flex items-center justify-center min-h-screen">

    <div class="text-center bg-white shadow-lg p-8 rounded-lg">
        <h1 class="text-3xl font-bold text-red-600">EduTend</h1>
        <p class="text-gray-600 mt-2">
            @auth 
                Anda bisa masuk ke dashboard atau keluar.
            @else
                Silakan masuk atau daftar untuk melanjutkan.
            @endauth
        </p>

        @auth
            <!-- Jika sudah login -->
            <a href="{{ url('/dashboard') }}" class="block w-full bg-red-600 text-white py-2 mt-4 rounded-lg hover:bg-red-700 transition duration-300">
                Dashboard
            </a>
            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full bg-gray-600 text-white py-2 rounded-lg hover:bg-gray-700 transition duration-300">
                    Logout
                </button>
            </form>
        @else
            <!-- Jika belum login -->
            <a href="{{ route('login') }}" class="block w-full bg-red-600 text-white py-2 mt-4 rounded-lg hover:bg-red-700 transition duration-300">
                Login
            </a>
            <a href="{{ route('register') }}" class="block w-full bg-gray-600 text-white py-2 mt-4 rounded-lg hover:bg-gray-700 transition duration-300">
                Register
            </a>
        @endauth
    </div>

</body>
</html>
