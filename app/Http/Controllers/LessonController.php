<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Menampilkan halaman index mata pelajaran
     */
    public function index()
    {
        $lessons = Lesson::all();
        return view('lessons.index', compact('lessons'));
    }

    /**
     * Menampilkan halaman buat mata pelajaran
     */
    public function create()
    {
        return view('lessons.create');
    }

    /**
     * Menyimpan pembuatan mata pelajaran
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:lessons']);

        Lesson::create($request->all());

        return redirect()->route('lessons.index')->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    /**
     * Menampilkan halaman edit mata pelajaran
     */
    public function edit($id)
    {
        $lesson = Lesson::findOrFail($id);
        return view('lessons.edit', compact('lesson'));
    }

    /**
     * Menyimpan edit mata pelajaran
     */
    public function update(Request $request, $id)
    {
        $lesson = Lesson::findOrFail($id);
        $request->validate(['name' => 'required|unique:lessons,name,' . $id]);

        $lesson->update($request->all());

        return redirect()->route('lessons.index')->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    /**
     * Menghapus mata pelajaran
     */
    public function destroy($id)
    {
        Lesson::destroy($id);
        return redirect()->route('lessons.index')->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
