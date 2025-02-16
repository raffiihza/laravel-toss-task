@extends('layouts.base')

@section('title', 'Edit Siswa')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4 text-gray-700">Edit Siswa</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('students.update', $student->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
        <x-input-label for="nisn" :value="__('NISN')" />
            <input type="number" id="nisn" name="nisn" value="{{ $student->nisn }}" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" required>
        </div>

        <div class="mb-4">
        <x-input-label for="name" :value="__('Nama Siswa')" />
            <input type="text" id="name" name="name" value="{{ $student->name }}"class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" required>
        </div>

        <div class="mb-4">
            <x-input-label for="gender" :value="__('Gender')" />
            <select id="gender" name="gender" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" required>
                <option value="Laki-laki" {{ $student->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ $student->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="mb-4">
            <x-input-label for="class_id" :value="__('Kelas')" />
            <select id="class_id" name="class_id" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" required>
                @foreach($grades as $grade)
                    <option value="{{ $grade->id }}" {{ $student->class_id == $grade->id ? 'selected' : '' }}>{{ $grade->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">
            Simpan
        </button>
        <a href="{{ route('students.index') }}" class="text-gray-600 ml-4">Batal</a>
    </form>
</div>
@endsection
