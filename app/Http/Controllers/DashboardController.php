<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Student;
use App\Models\Schedule;
use App\Models\Grade;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Jumlah total
        $teacherCount = User::whereNotNull('role')->count();
        $studentCount = Student::count();

        // Pembagian Guru Berdasarkan Role
        $teacherPerRole = User::whereNotNull('role')
            ->selectRaw('role, COUNT(*) as count')
            ->groupBy('role')
            ->pluck('count', 'role')
            ->toArray();

        // Pembagian Siswa Berdasarkan Kelas
        $studentPerGrade = Grade::withCount('students')->pluck('students_count', 'name')->toArray();

        // Jadwal Hari Ini
        $todaySchedules = Schedule::with('lesson', 'grade')
        ->where('day', Carbon::now()->isoFormat('dddd'))
        ->where('user_id', $user->id)
        ->get();

        return view('dashboard', compact(
            'teacherCount', 'studentCount',
            'teacherPerRole', 'studentPerGrade',
            'todaySchedules'
        ));
    }
}
