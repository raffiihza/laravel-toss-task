<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherAttendanceController;
use Illuminate\Support\Facades\Route;

// Untuk semua pengguna, bahkan tanpa login
Route::get('/', function () {
    return view('welcome');
});

// Untuk yang sudah login
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/attendance', [TeacherAttendanceController::class, 'index'])->name('attendance.index');
});

// Untuk guru saja
Route::get('/attendance/create', [TeacherAttendanceController::class, 'create'])->name('attendance.create');
Route::post('/attendance', [TeacherAttendanceController::class, 'store'])->name('attendance.store');

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
});

require __DIR__.'/auth.php';
