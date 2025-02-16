@extends('layouts.base')

@section('title', 'Edit Jadwal Pelajaran')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4 text-gray-700">Edit Jadwal Pelajaran</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('schedules.update', $schedule->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
        <x-input-label for="lesson_id" :value="__('Mata Pelajaran')" />
        <select id="lesson_id" name="lesson_id" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" required>
            @foreach ($lessons as $lesson)
                <option value="{{ $lesson->id }}" {{ $lesson->id == $schedule->lesson_id ? 'selected' : '' }}>{{ $lesson->name }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('lesson_id')" class="mt-2" />
        </div>

        <div class="mb-4">
        <x-input-label for="grade_id" :value="__('Kelas')" />
        <select id="grade_id" name="grade_id" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" required>
            @foreach ($grades as $grade)
                <option value="{{ $grade->id }}" {{ $grade->id == $schedule->grade_id ? 'selected' : '' }}>{{ $grade->name }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('grade_id')" class="mt-2" />
        </div>

        <div class="mb-4">
        <x-input-label for="user_id" :value="__('Guru')" />
        <select id="user_id" name="user_id" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" required>
            @foreach ($teachers as $teacher)
                <option value="{{ $teacher->id }}" {{ $teacher->id == $schedule->teacher_id ? 'selected' : '' }}>{{ $teacher->name }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
        </div>

        <div class="mb-4">
        <x-input-label for="day" :value="__('Hari')" />
        <select id="day" name="day" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" required>
            @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $day)
                <option value="{{ $day }}" {{ $schedule->day == $day ? 'selected' : '' }}>{{ $day }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('day')" class="mt-2" />
        </div>

        <div class="mb-4">
        <x-input-label for="start_time" :value="__('Jam Mulai')" />
            <input type="time" id="start_time" name="start_time" value="{{ $schedule->start_time }}" class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" required>
            <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
        </div>

        <div class="mb-4">
        <x-input-label for="end_time" :value="__('Jam Akhir')" />
            <input type="time" id="end_time" name="end_time" value="{{ $schedule->end_time }}"class="w-full px-4 py-2 mt-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-400" required>
            <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
        </div>

        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">
            Simpan
        </button>
        <a href="{{ route('schedules.index') }}" class="text-gray-600 ml-4">Batal</a>
    </form>
</div>
@endsection
