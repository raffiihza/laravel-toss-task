<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Menampilkan halaman index kelas
     */
    public function index()
    {
        $grades = Grade::all();
        return view('grades.index', compact('grades'));
    }

    /**
     * Menampilkan halaman membuat kelas
     */
    public function create()
    {
        return view('grades.create');
    }

    /**
     * Menyimpan pembuatan kelas
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:grades']);

        Grade::create($request->all());

        return redirect()->route('grades.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Menampilkan halaman edit kelas
     */
    public function edit($id)
    {
        $grade = Grade::findOrFail($id);
        return view('grades.edit', compact('grade'));
    }

    /**
     * Menyimpan edit kelas
     */
    public function update(Request $request, $id)
    {
        $grade = Grade::findOrFail($id);
        $request->validate(['name' => 'required|unique:grades,name,' . $id]);

        $grade->update($request->all());

        return redirect()->route('grades.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    /**
     * Menghapus kelas
     */
    public function destroy($id)
    {
        Grade::destroy($id);
        return redirect()->route('grades.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
