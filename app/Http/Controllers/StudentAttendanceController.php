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
     * Tampilkan daftar jadwal berdasarkan tanggal yang dipilih.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $selectedDate = $request->input('date', Carbon::today()->toDateString());

        // Jika admin, lihat semua jadwal, jika guru, lihat jadwal yang diajarnya
        $query = Schedule::with('lesson', 'grade', 'user')
            ->whereHas('grade.students') // Hanya kelas yang memiliki siswa
            ->where('day', Carbon::parse($selectedDate)->isoFormat('dddd')); // Filter berdasarkan hari

        if ($user->role === 'Guru') {
            $query->where('user_id', $user->id);
        }

        $schedules = $query->get();

        return view('studentattendances.index', compact('schedules', 'selectedDate'));
    }

    /**
     * Halaman edit presensi oleh guru.
     */
    public function edit($scheduleId, Request $request)
    {
        $selectedDate = $request->input('date', Carbon::today()->toDateString());
        $schedule = Schedule::with('lesson', 'grade.students')->findOrFail($scheduleId);

        // Pastikan hanya guru yang mengajar jadwal ini yang bisa mengelola
        if (Auth::user()->role !== 'Admin' && Auth::id() !== $schedule->user_id) {
            return redirect()->route('studentattendances.index')->with('error', 'Anda tidak berhak mengelola presensi ini.');
        }

        // Cek apakah agenda sudah ada atau buat baru
        $agenda = Agenda::firstOrCreate([
            'schedule_id' => $schedule->id,
            'date' => Carbon::parse($selectedDate)->toDateString(),
        ], ['content' => '']);

        // Ambil semua siswa dari kelas ini
        $students = $schedule->grade->students;

        // Ambil data presensi yang sudah ada
        $attendances = StudentAttendance::where('agenda_id', $agenda->id)->get()->keyBy('student_id');

        return view('studentattendances.edit', compact('schedule', 'agenda', 'students', 'attendances', 'selectedDate'));
    }

    /**
     * Simpan atau perbarui presensi siswa.
     */
    public function store(Request $request, $agendaId)
    {
        $request->validate([
            'agenda_content' => 'required|string',
            'attendance' => 'required|array',
            'attendance.*' => 'in:Hadir,Izin,Sakit,Alfa',
        ]);

        $agenda = Agenda::findOrFail($agendaId);

        // Pastikan hanya guru yang dapat mengedit agenda ini
        if (Auth::user()->role !== 'Admin' && Auth::id() !== $agenda->schedule->user_id) {
            return redirect()->route('studentattendances.index')->with('error', 'Anda tidak berhak mengelola presensi ini.');
        }

        // Perbarui isi agenda
        $agenda->update(['content' => $request->agenda_content]);

        // Simpan data presensi
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
     * Admin hanya bisa melihat presensi, tidak bisa mengedit.
     */
    public function show($scheduleId, Request $request)
    {
        $selectedDate = $request->input('date', Carbon::today()->toDateString());
        $schedule = Schedule::with('lesson', 'grade.students')->findOrFail($scheduleId);

        // Pastikan hanya admin yang bisa melihat
        if (Auth::user()->role !== 'Admin') {
            return redirect()->route('studentattendances.index', ['date' => $selectedDate])
                ->with('error', 'Anda tidak berhak mengelola presensi ini.');
        }

        // Cek apakah agenda sudah ada atau tidak
        $agenda = Agenda::where('schedule_id', $schedule->id)
            ->whereDate('date', Carbon::parse($selectedDate)->toDateString())
            ->first();

        // Ambil siswa dari kelas ini
        $students = $schedule->grade->students;

        // Ambil data presensi
        $attendances = $agenda ? StudentAttendance::where('agenda_id', $agenda->id)->get()->keyBy('student_id') : [];

        return view('studentattendances.show', compact('schedule', 'agenda', 'students', 'attendances', 'selectedDate'));
    }
}
