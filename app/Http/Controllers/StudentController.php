<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Grade;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with('grade')->get();
        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $grades = Grade::all();
        return view('students.create', compact('grades'));
    }

    /**
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $grades = Grade::all();
        return view('students.edit', compact('student', 'grades'));
    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Student::destroy($id);
        return redirect()->route('students.index')->with('success', 'Siswa berhasil dihapus.');
    }
}
