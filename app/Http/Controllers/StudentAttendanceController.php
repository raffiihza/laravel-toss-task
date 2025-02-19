<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentAttendance;
use App\Models\Agenda;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Grade;
use App\Models\User;
use Carbon\Carbon;

class StudentAttendanceController extends Controller
{
    /**
     * Menampilkan halaman index presensi siswa berdasarkan tanggal yang dipilih
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        // Input tanggal pada variabel date, jika kosong maka ambil hari ini
        $selectedDate = $request->input('date', Carbon::today()->toDateString());

        // Jika admin, lihat semua jadwal, jika guru, lihat jadwal yang diajarnya
        $query = Schedule::with('lesson', 'grade', 'user')
            ->whereHas('grade.students') // Hanya kelas yang memiliki siswa
            ->where('day', Carbon::parse($selectedDate)->isoFormat('dddd')); // Filter berdasarkan hari

        // Jika guru, filter lagi sesuai yang dimiliki guru
        if ($user->role === 'Guru') {
            $query->where('user_id', $user->id);
        }

        $schedules = $query->get();

        return view('studentattendances.index', compact('schedules', 'selectedDate'));
    }

    /**
     * Menampilkan halaman edit presensi oleh guru
     */
    public function edit($scheduleId, Request $request)
    {
        // Memastikan variabel date pada URL tidak kosong
        $selectedDate = $request->input('date', Carbon::today()->toDateString());
        // Ambil mata pelajaran dan murid sesuai kelas yang terkait dengan jadwal pelajaran
        $schedule = Schedule::with('lesson', 'grade.students')->findOrFail($scheduleId);

        // Pastikan hanya guru yang mengajar jadwal ini yang bisa mengelola
        if (Auth::id() !== $schedule->user_id) {
            return redirect()->route('studentattendances.index')->with('error', 'Anda tidak berhak mengelola presensi ini.');
        }

        // Cek apakah agenda sudah ada atau buat baru
        // Buat baru diperlukan untuk menghindari error
        $agenda = Agenda::firstOrCreate([
            'schedule_id' => $schedule->id,
            'date' => Carbon::parse($selectedDate)->toDateString(),
        ], ['content' => '']);

        // Ambil semua siswa dari jadwal pelajaran dan kelas ini
        $students = $schedule->grade->students;

        // Ambil data presensi yang sudah ada, jika kosong tidak masalah
        $attendances = StudentAttendance::where('agenda_id', $agenda->id)->get()->keyBy('student_id');

        return view('studentattendances.edit', compact('schedule', 'agenda', 'students', 'attendances', 'selectedDate'));
    }

    /**
     * Menyimpan buat dan presensi siswa
     */
    public function store(Request $request, $agendaId)
    {
        $request->validate([
            'agenda_content' => 'required|string',
            'attendance' => 'required|array', // Pastikan dalam bentuk array
            'attendance.*' => 'in:Hadir,Izin,Sakit,Alfa', // Pastikan data dalam array sesuai
        ]);

        $agenda = Agenda::findOrFail($agendaId);

        // Pastikan hanya guru yang dapat mengedit agenda ini
        if (Auth::id() !== $agenda->schedule->user_id) {
            return redirect()->route('studentattendances.index')->with('error', 'Anda tidak berhak mengelola presensi ini.');
        }

        // Perbarui isi agenda
        $agenda->update(['content' => $request->agenda_content]);

        // Simpan data presensi setiap siswa
        foreach ($request->attendance as $studentId => $status) {
            StudentAttendance::updateOrCreate(
                ['agenda_id' => $agenda->id, 'student_id' => $studentId],
                ['status' => $status]
            );
        }

        return redirect()->route('studentattendances.index', ['date' => $agenda->date])
            ->with('success', 'Presensi berhasil disimpan.');
    }

    /**
     * Menampilkan halaman lihat presensi oleh admin
     * Admin hanya bisa melihat presensi, tidak bisa mengedit
     */
    public function show($scheduleId, Request $request)
    {
        $selectedDate = $request->input('date', Carbon::today()->toDateString());
        $schedule = Schedule::with('lesson', 'grade.students')->findOrFail($scheduleId);

        // Pastikan hanya admin yang bisa melihat
        if (Auth::user()->role !== 'Admin') {
            return redirect()->route('studentattendances.index', ['date' => $selectedDate])
                ->with('error', 'Anda tidak berhak melihat presensi ini.');
        }

        // Cek apakah agenda sudah ada atau tidak
        $agenda = Agenda::where('schedule_id', $schedule->id)
            ->whereDate('date', Carbon::parse($selectedDate)->toDateString())
            ->first();

        // Ambil siswa dari jadwal pelajaran dan kelas ini
        $students = $schedule->grade->students;

        // Ambil data presensi
        $attendances = $agenda ? StudentAttendance::where('agenda_id', $agenda->id)->get()->keyBy('student_id') : [];

        return view('studentattendances.show', compact('schedule', 'agenda', 'students', 'attendances', 'selectedDate'));
    }
}
