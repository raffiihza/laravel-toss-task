@extends('layouts.base')

@section('content')
<div class="container">
    <h2>Kelola Presensi - {{ $schedule->lesson->name }} ({{ $schedule->grade->name }})</h2>
    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($selectedDate)->isoFormat('dddd, D MMMM YYYY') }}</p>

    <!-- Form Agenda -->
    <form method="POST" action="{{ route('studentattendances.store', ['agenda' => $agenda->id]) }}">
        @csrf
        <div class="mb-3">
            <label for="agenda_content" class="form-label">Agenda:</label>
            <textarea name="agenda_content" id="agenda_content" class="form-control" rows="3" required>{{ $agenda->content }}</textarea>
        </div>

        <!-- Tabel Presensi -->
        <h4>Presensi Siswa</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>
                        <select name="attendance[{{ $student->id }}]" class="form-select">
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

        <button type="submit" class="btn btn-success">Simpan Presensi</button>
    </form>
</div>
@endsection
