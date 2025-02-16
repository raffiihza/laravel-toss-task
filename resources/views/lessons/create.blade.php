@extends('layouts.base')

@section('title', 'Tambah Mata Pelajaran')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4 text-gray-700">Tambah Mata Pelajaran</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('lessons.store') }}" method="POST">
        @csrf
        <div class="mb-4">
        <x-input-label for="name" :value="__('Nama Mata Pelajaran')" />
            <input type="text" id="name" name="name" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" required>
        </div>

        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">
            Simpan
        </button>
        <a href="{{ route('lessons.index') }}" class="text-gray-600 ml-4">Batal</a>
    </form>
</div>
@endsection
