@extends('layouts.base')

@section('title', 'Edit Presensi Siswa')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <!-- Ambil data agar mudah dilihat -->
    <h1 class="text-2xl font-bold mb-4 text-gray-700">Edit Presensi - {{ $schedule->lesson->name }} ({{ $schedule->grade->name }})</h1>
    <p><strong>Hari, Tanggal:</strong> {{ \Carbon\Carbon::parse($selectedDate)->isoFormat('dddd, D MMMM YYYY') }}</p>
    <p><strong>Mata Pelajaran:</strong> {{ $schedule->lesson->name }}</p>
    <p><strong>Kelas:</strong> {{ $schedule->grade->name }}</p>
    <p><strong>Guru:</strong> {{ $schedule->user->name }}</p>
    <p><strong>Waktu:</strong> {{ $schedule->start_time }} - {{ $schedule->end_time }}</p>

    <!-- Form Agenda -->
    <form method="POST" action="{{ route('studentattendances.store', ['agenda' => $agenda->id]) }}">
        @csrf

        <div class="mt-4 mb-4">
        <x-input-label for="agenda_content" :value="__('Agenda')" />
            <textarea id="agenda_content" name="agenda_content" rows="3" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" required>{{ $agenda->content }}</textarea>
        </div>

        <!-- Tabel Presensi -->
        <div class="mt-4 mb-4">
            <x-input-label :value="__('Presensi Siswa')" class="mb-2" />
            <table id="indexTable" class="w-full border-collapse border border-gray-200 shadow-md rounded-lg">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                        <th class="border border-gray-300 px-4 py-3">No</th>
                        <th class="border border-gray-300 px-4 py-3">NISN</th>
                        <th class="border border-gray-300 px-4 py-3">Nama Siswa</th>
                        <th class="border border-gray-300 px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                    @foreach($students as $index => $student)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-3 text-center">{{ $index + 1 }}</td>
                        <td class="border border-gray-300 px-4 py-3">{{ $student->nisn }}</td>
                        <td class="border border-gray-300 px-4 py-3">{{ $student->name }}</td>
                        <td class="border border-gray-300 px-4 py-3">
                            <!-- Cek apakah siswa sudah diabsen, jika ada, tampilkan -->
                            <select id="attendance[{{ $student->id }}]" name="attendance[{{ $student->id }}]" class="w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" required>
                                @php
                                    $status = $attendances[$student->id]->status ?? '';
                                @endphp
                                <option value="Hadir" {{ $status == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="Izin" {{ $status == 'Izin' ? 'selected' : '' }}>Izin</option>
                                <option value="Sakit" {{ $status == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="Alfa" {{ $status == 'Alfa' ? 'selected' : '' }}>Alfa</option>
                            </select>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">
            Simpan
        </button>
        <a href="{{ route('studentattendances.index', ['date' => $selectedDate]) }}" class="text-gray-600 ml-4">Batal</a>
    </form>
</div>
@endsection
