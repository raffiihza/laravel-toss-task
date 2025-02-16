@extends('layouts.base')

@section('title', 'Tambah Guru')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4 text-gray-700">Tambah Guru</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('teachers.store') }}" method="POST">
        @csrf

        <div class="mb-4">
        <x-input-label for="nip" :value="__('NIP')" />
            <input type="number" id="nip" name="nip" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" required>
            <x-input-error :messages="$errors->get('nip')" class="mt-2" />
        </div>

        <div class="mb-4">
        <x-input-label for="name" :value="__('Nama Guru')" />
            <input type="text" id="name" name="name" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" required>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mb-4">
        <x-input-label for="email" :value="__('Email')" />
            <input type="email" id="email" name="email" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" required>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-4">
        <x-input-label for="phone" :value="__('Nomor Telepon')" />
            <input type="number" id="phone" name="phone" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" required>
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-input-label for="gender" :value="__('Gender')" />
            <select id="gender" name="gender" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" required>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">
            Simpan
        </button>
        <a href="{{ route('teachers.index') }}" class="text-gray-600 ml-4">Batal</a>
    </form>
</div>
@endsection
