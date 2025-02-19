<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Lesson;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Menampilkan halaman index jadwal pelajaran
     */
    public function index()
    {
        // Ambil mata pelajaran, kelas, dan guru yang berkaitan dengan jadwal
        $schedules = Schedule::with(['lesson', 'grade', 'teacher'])->get();
        return view('schedules.index', compact('schedules'));
    }

    /**
     * Menampilkan halaman buat jadwal pelajaran
     */
    public function create()
    {
        // Ambil semua mata pelajaran dan kelas untuk dipilih
        $lessons = Lesson::all();
        $grades = Grade::all();
        // Pastikan hanya guru yang bisa dipilih untuk mengajar pada jadwal pelajaran
        $teachers = User::where('role', 'Guru')->get();
        return view('schedules.create', compact('lessons', 'grades', 'teachers'));
    }

    /**
     * Menyimpan tambah jadwal pelajaran
     */
    public function store(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'grade_id' => 'required|exists:grades,id',
            'user_id' => 'required|exists:users,id',
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat', // Pastikan sesuai dengan nama hari
            'start_time' => 'required|date_format:H:i', // Pastikan berbentuk waktu
            'end_time' => 'required|date_format:H:i|after:start_time', // Pastikan berbentuk waktu dan setelah waktu mulai
        ]);

        Schedule::create($request->all());

        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Menampilkan halaman edit jadwal pelajaran
     */
    public function edit($id)
    {
        // Ambil semua data yang terkait
        $schedule = Schedule::findOrFail($id);
        $lessons = Lesson::all();
        $grades = Grade::all();
        $teachers = User::where('role', 'Guru')->get();
        return view('schedules.edit', compact('schedule', 'lessons', 'grades', 'teachers'));
    }

    /**
     * Menyimpan edit jadwal pelajaran
     */
    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);

        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'grade_id' => 'required|exists:grades,id',
            'user_id' => 'required|exists:users,id',
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat', // Pastikan hari sesuai
            'start_time' => 'required|date_format:H:i', // Pastikan format waktu
            'end_time' => 'required|date_format:H:i|after:start_time', // Pastikan format waktu dan setelah waktu mulai
        ]);

        $schedule->update($request->all());

        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Hapus data jadwal pelajaran
     */
    public function destroy($id)
    {
        Schedule::destroy($id);
        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
