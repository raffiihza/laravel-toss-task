@extends('layouts.base')

@section('title', 'Tambah Absen')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4 text-gray-700">Tambah Absen</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('teacherattendances.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
        <x-input-label for="status" :value="__('Status Kehadiran')" />
            <select id="status" name="status" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" required>
                <option value="Hadir">Hadir</option>
                <option value="Izin">Izin</option>
                <option value="Sakit">Sakit</option>
                <option value="Cuti">Cuti</option>
            </select>
            <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>

        <div class="mb-4">
        <x-input-label for="proof" :value="__('Bukti Kehadiran (Foto)')" />
            <input type="file" name="proof" id="proof" class="form-control w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" required accept="image/*">
            <x-input-error :messages="$errors->get('proof')" class="mt-2" />
        </div>

        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">
            Simpan
        </button>
        <a href="{{ route('teacherattendances.index') }}" class="text-gray-600 ml-4">Batal</a>
    </form>
</div>
@endsection
