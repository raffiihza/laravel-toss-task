<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
        <h2 class="text-2xl font-bold text-center text-red-600">Login</h2>

        @if (session('status'))
            <div class="bg-red-100 text-red-700 p-2 rounded mt-4">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="mt-6">
            @csrf

            <div>
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" required
                    class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <button type="submit"
                class="w-full mt-6 bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition duration-300">
                Login
            </button>

            <p class="mt-4 text-center text-gray-600">
                Belum punya akun? <a href="{{ route('register') }}" class="text-red-500 hover:underline">Daftar</a>
            </p>
        </form>
    </div>

</body>
</html>
