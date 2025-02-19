<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Grade;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Menampilkan halaman index siswa
     */
    public function index()
    {
        $students = Student::with('grade')->get();
        return view('students.index', compact('students'));
    }

    /**
     * Menampilkan halaman buat siswa
     */
    public function create()
    {
        // Tampilkan semua kelas yang ada untuk dipilih
        $grades = Grade::all();
        return view('students.create', compact('grades'));
    }

    /**
     * Menyimpan tambah siswa
     */
    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|unique:students',
            'name' => 'required',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'class_id' => 'required|exists:grades,id',
        ]);

        Student::create($request->all());

        return redirect()->route('students.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    /**
     * Menampilkan halaman edit siswa
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        // Ambil semua data kelas untuk dipilih
        $grades = Grade::all();
        return view('students.edit', compact('student', 'grades'));
    }

    /**
     * Menyimpan edit siswa
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $request->validate([
            'nisn' => 'required|unique:students,nisn,' . $id,
            'name' => 'required',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'class_id' => 'required|exists:grades,id',
        ]);

        $student->update($request->all());

        return redirect()->route('students.index')->with('success', 'Siswa berhasil diperbarui.');
    }

    /**
     * Menghapus data siswa
     */
    public function destroy($id)
    {
        Student::destroy($id);
        return redirect()->route('students.index')->with('success', 'Siswa berhasil dihapus.');
    }
}
