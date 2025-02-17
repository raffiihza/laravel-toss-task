@extends('layouts.base')

@section('title', 'Daftar Presensi Siswa')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4 text-gray-700">Daftar Presensi Siswa</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Pilih Tanggal -->
    <form method="GET" action="{{ route('studentattendances.index') }}">
        <div class="mb-4">
            <x-input-label for="date" :value="__('Tanggal')" />
            <input type="date" id="date" name="date" value="{{ $selectedDate }}" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" required>
            <x-input-error :messages="$errors->get('date')" class="mt-2" />
        </div>

        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md mb-4 inline-block">
            Tampilkan
        </button>
    </form>

    <h2 class="font-bold mb-4 text-gray-700">
        {{ \Carbon\Carbon::parse($selectedDate)->isoFormat('dddd, D MMMM YYYY') }}
    </h2>

    <!-- Tabel Jadwal -->
    <table id="indexTable" class="w-full border-collapse border border-gray-200 shadow-md rounded-lg">
        <thead>
            <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                <th class="border border-gray-300 px-4 py-3">No</th>
                <th class="border border-gray-300 px-4 py-3">Mata Pelajaran</th>
                <th class="border border-gray-300 px-4 py-3">Kelas</th>
                <th class="border border-gray-300 px-4 py-3">Guru</th>
                <th class="border border-gray-300 px-4 py-3">Jam</th>
                <th class="border border-gray-300 px-4 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm">
            @foreach($schedules as $index => $schedule)
            <tr class="border-b border-gray-200 hover:bg-gray-50">
                <td class="border border-gray-300 px-4 py-3 text-center">{{ $index + 1 }}</td> 
                <td class="border border-gray-300 px-4 py-3">{{ $schedule->lesson->name }}</td>
                <td class="border border-gray-300 px-4 py-3">{{ $schedule->grade->name }}</td>
                <td class="border border-gray-300 px-4 py-3">{{ $schedule->user->name }}</td>
                <td class="border border-gray-300 px-4 py-3">{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                <td class="border border-gray-300 px-4 py-3">
                    @if(auth()->user()->role === 'Admin')
                        <a href="{{ route('studentattendances.show', ['schedule' => $schedule->id, 'date' => $selectedDate]) }}" class="bg-red-600 text-white px-2 py-1 rounded">Lihat</a>
                    @else
                        <a href="{{ route('studentattendances.edit', ['schedule' => $schedule->id, 'date' => $selectedDate]) }}" class="bg-red-600 text-white px-2 py-1 rounded">Edit</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
