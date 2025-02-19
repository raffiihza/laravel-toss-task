<?php

namespace App\Http\Controllers;

use App\Models\TeacherAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive_Permission;

class TeacherAttendanceController extends Controller
{
    /**
     * Menampilkan halaman index presensi guru
     */
    public function index()
    {
        $user = Auth::user();

        // Jika admin, tampilkan semua presensi dari semua guru
        // Jika guru, tampilkan semua presensi dari guru tersebut
        if ($user->role === 'Admin') {
            $attendances = TeacherAttendance::with('user')->get();
        } else {
            $attendances = TeacherAttendance::where('user_id', $user->id)->get();
        }

        // Mengubah format tanggal pada halaman agar mudah dibaca
        foreach ($attendances as $attendance) {
            $attendance->formatted_date = \Carbon\Carbon::parse($attendance->created_at)
                ->translatedFormat('l, d F Y H:i');
        }

        return view('teacherattendances.index', compact('attendances'));
    }

    /**
     * Menampilkan halaman buat presensi guru
     */
    public function create()
    {
        return view('teacherattendances.create');
    }

    /**
     * Menyimpan tambah presensi guru
     */
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|in:Hadir,Izin,Sakit,Cuti',
            'proof' => 'required|image|max:2048', // Pastikan di bawah 2MB dan berformat gambar
        ]);

        // Panggil fungsi upload ke Google Drive
        $proofLink = $this->uploadToGoogleDrive($request->file('proof'));

        TeacherAttendance::create([
            'user_id' => Auth::id(),
            'status' => $request->status,
            'proof' => $proofLink,
        ]);

        return redirect()->route('teacherattendances.index')->with('success', 'Presensi berhasil dikirim.');
    }

    /**
     * Fungsi upload ke Google Drive
     */
    private function uploadToGoogleDrive($file)
    {
        // Ambil konfigurasi dari env
        $client = new Google_Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->refreshToken(config('services.google.refresh_token'));

        $service = new Google_Service_Drive($client);

        // Sesuaikan metadata dari nama file dan folder id tujuan
        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $file->getClientOriginalName(),
            'parents' => [config('services.google.folder_id')]
        ]);

        // Upload file ke server Laravel dulu dan ambil path file dalam server
        $content = file_get_contents($file->getRealPath());

        // Upload file ke Google Drive
        $driveFile = $service->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => $file->getMimeType(),
            'uploadType' => 'multipart',
            'fields' => 'id',
        ]);

        // Ambil file id untuk dimasukkan ke database
        $fileId = $driveFile->id;

        // Ubah permission file menjadi publik
        $service->permissions->create($fileId, new \Google_Service_Drive_Permission([
            'type' => 'anyone',
            'role' => 'reader',
        ]));

        // Jadikan link file di Google Drive sebagai output fungsi
        return "https://drive.google.com/file/d/{$fileId}/view";
    }

}
