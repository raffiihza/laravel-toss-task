@extends('layouts.base')

@section('title', 'Tambah Kelas')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4 text-gray-700">Tambah Kelas</h1>

    <form action="{{ route('grades.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <x-input-label for="name" :value="__('Nama Kelas')" />
            <input type="text" name="name" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" required>
            @error('name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Simpan</button>
        <a href="{{ route('grades.index') }}" class="ml-2 text-gray-600">Batal</a>
    </form>
</div>
@endsection
