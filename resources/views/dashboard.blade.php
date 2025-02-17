@extends('layouts.base')
@section('title', 'Dashboard')

@section('content')
    <div class="bg-white p-6 shadow rounded-lg">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6">Selamat datang, {{ Auth::user()->name }}!</h2>

        <!-- Grid Dashboard -->
        <div class="grid grid-cols-3 gap-6">
            <!-- Kotak Angka -->
            <div class="bg-blue-100 p-4 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-700">Jumlah Guru</h3>
                <p class="text-2xl font-bold text-blue-600">{{ $teacherCount }}</p>
            </div>

            <div class="bg-green-100 p-4 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-700">Jumlah Siswa</h3>
                <p class="text-2xl font-bold text-green-600">{{ $studentCount }}</p>
            </div>

            <!-- Jadwal Hari Ini -->
            <div class="bg-yellow-100 p-4 rounded-lg shadow-md row-span-2">
                <h3 class="text-lg font-semibold text-gray-700">Jadwal Hari Ini</h3>
                <ul class="mt-2 space-y-2">
                    @forelse ($todaySchedules as $schedule)
                        <li class="text-gray-600">
                            <strong>{{ $schedule->lesson->name }}</strong> - {{ $schedule->grade->name }}
                            <span class="block text-sm">{{ $schedule->start_time }} - {{ $schedule->end_time }}</span>
                        </li>
                    @empty
                        <p class="text-sm text-gray-500">Tidak ada jadwal untuk hari ini.</p>
                    @endforelse
                </ul>
            </div>

            <!-- Pie Chart Guru -->
            <div class="bg-red-100 p-4 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-700">Pembagian Guru</h3>
                <canvas id="teacherPieChart"></canvas>
            </div>

            <!-- Pie Chart Siswa -->
            <div class="bg-indigo-100 p-4 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-700">Pembagian Siswa</h3>
                <canvas id="studentPieChart"></canvas>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Pie Chart Guru berdasarkan Role
        const teacherPieChart = document.getElementById('teacherPieChart').getContext('2d');
        new Chart(teacherPieChart, {
            type: 'pie',
            data: {
                labels: {!! json_encode(array_keys($teacherPerRole)) !!},
                datasets: [{
                    data: {!! json_encode(array_values($teacherPerRole)) !!},
                    backgroundColor: ['#3b82f6', '#f43f5e', '#10b981', '#f59e0b', '#eab308'],
                }]
            }
        });

        // Pie Chart Siswa berdasarkan Kelas
        const studentPieChart = document.getElementById('studentPieChart').getContext('2d');
        new Chart(studentPieChart, {
            type: 'pie',
            data: {
                labels: {!! json_encode(array_keys($studentPerGrade)) !!},
                datasets: [{
                    data: {!! json_encode(array_values($studentPerGrade)) !!},
                    backgroundColor: ['#6366f1', '#f59e0b', '#10b981', '#f43f5e', '#eab308'],
                }]
            }
        });
    </script>
@endsection
