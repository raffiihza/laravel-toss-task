<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherAttendanceController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StudentAttendanceController;
use Illuminate\Support\Facades\Route;

// Untuk semua pengguna, bahkan tanpa login
Route::get('/', function () {
    return view('welcome');
});

// Untuk yang sudah login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/attendances/teachers', [TeacherAttendanceController::class, 'index'])->name('teacherattendances.index');
    Route::get('/attendances/teachers/create', [TeacherAttendanceController::class, 'create'])->name('teacherattendances.create');
    Route::post('/attendances/teachers', [TeacherAttendanceController::class, 'store'])->name('teacherattendances.store');

    Route::get('/attendances/students', [StudentAttendanceController::class, 'index'])->name('studentattendances.index');
    Route::get('/attendances/students/edit/{schedule}', [StudentAttendanceController::class, 'edit'])->name('studentattendances.edit');
    Route::post('/attendances/students/store/{agenda}', [StudentAttendanceController::class, 'store'])->name('studentattendances.store');
    Route::get('/attendances/students/show/{schedule}', [StudentAttendanceController::class, 'show'])->name('studentattendances.show');
});

// Untuk guru saja
Route::middleware(['auth','guru'])->group(function () {
    
});

// Untuk admin saja
Route::middleware(['auth','admin'])->group(function () {
    
    // Routes untuk Grade (Kelas)
    Route::get('/grades', [GradeController::class, 'index'])->name('grades.index'); // Tampilkan semua kelas
    Route::get('/grades/create', [GradeController::class, 'create'])->name('grades.create'); // Form tambah kelas
    Route::post('/grades', [GradeController::class, 'store'])->name('grades.store'); // Simpan kelas baru
    Route::get('/grades/{id}/edit', [GradeController::class, 'edit'])->name('grades.edit'); // Form edit kelas
    Route::put('/grades/{id}', [GradeController::class, 'update'])->name('grades.update'); // Update kelas
    Route::delete('/grades/{id}', [GradeController::class, 'destroy'])->name('grades.destroy'); // Hapus kelas

    // Routes untuk Lesson (Mata Pelajaran)
    Route::get('/lessons', [LessonController::class, 'index'])->name('lessons.index');
    Route::get('/lessons/create', [LessonController::class, 'create'])->name('lessons.create');
    Route::post('/lessons', [LessonController::class, 'store'])->name('lessons.store');
    Route::get('/lessons/{id}/edit', [LessonController::class, 'edit'])->name('lessons.edit');
    Route::put('/lessons/{id}', [LessonController::class, 'update'])->name('lessons.update');
    Route::delete('/lessons/{id}', [LessonController::class, 'destroy'])->name('lessons.destroy');

    // Routes untuk Student (Siswa)
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

    // Route untuk Teacher (Guru)
    Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
    Route::get('/teachers/create', [TeacherController::class, 'create'])->name('teachers.create');
    Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store');
    Route::get('/teachers/{id}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
    Route::put('/teachers/{id}', [TeacherController::class, 'update'])->name('teachers.update');
    Route::delete('/teachers/{id}', [TeacherController::class, 'destroy'])->name('teachers.destroy');
    Route::post('/teachers/{id}/reset-password', [TeacherController::class, 'resetPassword'])->name('teachers.reset-password');

    Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index'); // Menampilkan daftar jadwal
    Route::get('/schedules/create', [ScheduleController::class, 'create'])->name('schedules.create'); // Form tambah jadwal
    Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedules.store'); // Proses simpan jadwal baru
    Route::get('/schedules/{id}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit'); // Form edit jadwal
    Route::put('/schedules/{id}', [ScheduleController::class, 'update'])->name('schedules.update'); // Proses update jadwal
    Route::delete('/schedules/{id}', [ScheduleController::class, 'destroy'])->name('schedules.destroy'); // Hapus jadwal
});

require __DIR__.'/auth.php';
