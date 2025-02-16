<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
        <h2 class="text-2xl font-bold text-center text-red-600">Register</h2>

        <form method="POST" action="{{ route('register') }}" class="mt-6">
            @csrf

            <div>
                <label class="block text-gray-700">NIP</label>
                <input type="number" name="nip" required
                    class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400">
                <x-input-error :messages="$errors->get('nip')" class="mt-2" />
            </div>

            <div class="mt-4">
                <label class="block text-gray-700">Nama</label>
                <input type="text" name="name" required
                    class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" required
                    class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <label class="block text-gray-700">Jenis Kelamin</label>
                <select name="gender" required
                    class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400">
                    <option value="Laki-Laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
            </div>

            <div class="mt-4">
                <label class="block text-gray-700">Nomor Telepon</label>
                <input type="number" name="phone" required
                    class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400">
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <div class="mt-4">
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-4">
                <label class="block text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required
                    class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <button type="submit"
                class="w-full mt-6 bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition duration-300">
                Daftar
            </button>

            <p class="mt-4 text-center text-gray-600">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-red-500 hover:underline">Login</a>
            </p>
        </form>
    </div>

</body>
</html>
