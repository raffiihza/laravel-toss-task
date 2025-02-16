@extends('layouts.base')

@section('title', 'Daftar Jadwal Pelajaran')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4 text-gray-700">Daftar Jadwal Pelajaran</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('schedules.create') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md mb-4 inline-block">
        + Tambah Jadwal Pelajaran
    </a>

    <div class="overflow-x-auto">
        <table id="indexTable" class="w-full border-collapse border border-gray-200 shadow-md rounded-lg">
            <thead>
                <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                    <th class="border border-gray-300 px-4 py-3">No</th>
                    <th class="border border-gray-300 px-4 py-3">Mapel</th>
                    <th class="border border-gray-300 px-4 py-3">Kelas</th>
                    <th class="border border-gray-300 px-4 py-3">Guru</th>
                    <th class="border border-gray-300 px-4 py-3">Hari</th>
                    <th class="border border-gray-300 px-4 py-3">Jam Mulai</th>
                    <th class="border border-gray-300 px-4 py-3">Jam Akhir</th>
                    <th class="border border-gray-300 px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @foreach ($schedules as $index => $schedule)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="border border-gray-300 px-4 py-3 text-center">{{ $index + 1 }}</td>
                    <td class="border border-gray-300 px-4 py-3">{{ $schedule->lesson->name }}</td>
                    <td class="border border-gray-300 px-4 py-3">{{ $schedule->grade->name }}</td>
                    <td class="border border-gray-300 px-4 py-3">{{ $schedule->teacher->name }}</td>
                    <td class="border border-gray-300 px-4 py-3">{{ $schedule->day }}</td>
                    <td class="border border-gray-300 px-4 py-3">{{ $schedule->start_time }}</td>
                    <td class="border border-gray-300 px-4 py-3">{{ $schedule->end_time }}</td>
                    <td class="border border-gray-300 px-4 py-3 justify-center">
                        <a href="{{ route('schedules.edit', $schedule->id) }}" class="bg-red-600 text-white px-2 py-1 rounded">Edit</a>
                        <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded"
                                onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection