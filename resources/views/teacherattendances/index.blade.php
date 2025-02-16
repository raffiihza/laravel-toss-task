@extends('layouts.base')

@section('title', 'Daftar Absensi Guru')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4 text-gray-700">Daftar Absensi Guru</h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(Auth::user()->role == 'Guru')
    <a href="{{ route('teacherattendances.create') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md mb-4 inline-block">
        + Tambah Absen
    </a>
    @endif

    <div class="overflow-x-auto">
    <table id="indexTable" class="w-full border-collapse border border-gray-200 shadow-md rounded-lg">
            <thead>
                <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                    <th class="border border-gray-300 px-4 py-3">No</th>
                    <th class="border border-gray-300 px-4 py-3">Nama</th>
                    <th class="border border-gray-300 px-4 py-3">Status</th>
                    <th class="border border-gray-300 px-4 py-3">Bukti</th>
                    <th class="border border-gray-300 px-4 py-3">Tanggal</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @foreach ($attendances as $index => $attendance)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="border border-gray-300 px-4 py-3">{{ $index + 1 }}</td>
                    <td class="border border-gray-300 px-4 py-3">{{ $attendance->user->name }}</td>
                    <td class="border border-gray-300 px-4 py-3">{{ $attendance->status }}</td>
                    <td class="border border-gray-300 px-4 py-3">
                    @if($attendance->proof)
                        <a href="{{ $attendance->proof }}" class="bg-red-600 text-white px-2 py-1 rounded" target="_blank">Lihat Bukti</a>
                    @else
                        Tidak Ada
                    @endif
                    </td>
                    <td class="border border-gray-300 px-4 py-3">{{ $attendance->formatted_date }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
