<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    /**
     * Menampilkan halaman index guru
     */
    public function index()
    {
        // Hanya ambil user dengan role guru
        $teachers = User::where('role', 'Guru')->get();
        return view('teachers.index', compact('teachers'));
    }

    /**
     * Menampilkan halaman tambah guru
     */
    public function create()
    {
        return view('teachers.create');
    }

    /**
     * Menyimpan tambah guru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:users',
            'name' => 'required',
            'phone' => 'required',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'email' => 'required|email|unique:users',
        ]);

        User::create([
            'nip' => $request->nip,
            'name' => $request->name,
            'gender' => $request->gender,
            'email' => $request->email,
            'role' => 'Guru',
            'phone' => $request->phone,
            'password' => Hash::make('sekolah123'), // Password default
        ]);

        return redirect()->route('teachers.index')->with('success', 'Akun guru berhasil ditambahkan dengan password default "sekolah123".');
    }

    /**
     * Menampilkan halaman edit guru
     */
    public function edit($id)
    {
        $teachers = User::findOrFail($id);
        return view('teachers.edit', compact('teachers'));
    }

    /**
     * Menyimpan edit guru
     */
    public function update(Request $request, $id)
    {
        $teacher = User::findOrFail($id);

        $request->validate([
            'nip' => 'required|unique:users,nip,' . $id,
            'name' => 'required',
            'phone' => 'required',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $teacher->update([
            'nip' => $request->nip,
            'name' => $request->name,
            'gender' => $request->gender,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('teachers.index')->with('success', 'Akun guru berhasil diperbarui.');
    }

    /**
     * Menghapus data guru
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('teachers.index')->with('success', 'Akun guru berhasil dihapus.');
    }

    /**
     * Melakukan reset password akun guru
     */
    public function resetPassword($id)
    {
        $teacher = User::findOrFail($id);
        // Menjadikan password akun tersebut ke default
        $teacher->update([
            'password' => Hash::make('sekolah123'),
        ]);

        return redirect()->route('teachers.index')->with('success', 'Password berhasil direset ke sekolah123.');
    }
}
