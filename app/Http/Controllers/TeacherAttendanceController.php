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
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'Admin') {
            $attendances = TeacherAttendance::with('user')->get();
        } else {
            $attendances = TeacherAttendance::where('user_id', $user->id)->get();
        }

        return view('teacherattendances.index', compact('attendances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('attendance.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|in:Hadir,Izin,Sakit,Cuti',
            'proof' => 'required|image|max:2048',
        ]);

        $proofLink = $this->uploadToGoogleDrive($request->file('proof'));

        TeacherAttendance::create([
            'user_id' => Auth::id(),
            'status' => $request->status,
            'proof' => $proofLink,
        ]);

        return redirect()->route('attendance.index')->with('success', 'Presensi berhasil dikirim.');
    }

    private function uploadToGoogleDrive($file)
    {
        $client = new Google_Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->refreshToken(config('services.google.refresh_token'));

        $service = new Google_Service_Drive($client);

        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $file->getClientOriginalName(),
            'parents' => [config('services.google.folder_id')]
        ]);

        $content = file_get_contents($file->getRealPath());

        $driveFile = $service->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => $file->getMimeType(),
            'uploadType' => 'multipart',
            'fields' => 'id',
        ]);

        $fileId = $driveFile->id;

        // Set file to public
        $service->permissions->create($fileId, new \Google_Service_Drive_Permission([
            'type' => 'anyone',
            'role' => 'reader',
        ]));

        return "https://drive.google.com/file/d/{$fileId}/view";
    }

    /**
     * Display the specified resource.
     */
    public function show(TeacherAttendance $teacherAttendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeacherAttendance $teacherAttendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TeacherAttendance $teacherAttendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeacherAttendance $teacherAttendance)
    {
        //
    }
}
