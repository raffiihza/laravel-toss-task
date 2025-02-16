@extends('layouts.base')

@section('title', 'Daftar Guru')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4 text-gray-700">Daftar Guru</h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('teachers.create') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md mb-4 inline-block">
        + Tambah Guru
    </a>

    <div class="overflow-x-auto">
    <table id="indexTable" class="w-full border-collapse border border-gray-200 shadow-md rounded-lg">
            <thead>
                <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                    <th class="border border-gray-300 px-4 py-3">No</th>
                    <th class="border border-gray-300 px-4 py-3">NIP</th>
                    <th class="border border-gray-300 px-4 py-3">Nama</th>
                    <th class="border border-gray-300 px-4 py-3">Telepon</th>
                    <th class="border border-gray-300 px-4 py-3">Email</th>
                    <th class="border border-gray-300 px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @foreach ($teachers as $index => $teacher)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="border border-gray-300 px-4 py-3">{{ $index + 1 }}</td>
                    <td class="border border-gray-300 px-4 py-3">{{ $teacher->nip }}</td>
                    <td class="border border-gray-300 px-4 py-3">{{ $teacher->name }}</td>
                    <td class="border border-gray-300 px-4 py-3">{{ $teacher->phone }}</td>
                    <td class="border border-gray-300 px-4 py-3">{{ $teacher->email }}</td>
                    <td class="border border-gray-300 px-4 py-3">
                        <a href="{{ route('teachers.edit', $teacher->id) }}" class="bg-red-600 text-white px-2 py-1 rounded">Edit</a> 
                        <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded">Hapus</button>
                        </form> 
                        <form action="{{ route('teachers.reset-password', $teacher->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded" onclick="return confirm('Apakah ingin mereset password ke sekolah123?')">Reset Password</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
