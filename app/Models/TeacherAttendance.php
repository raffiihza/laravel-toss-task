<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // Guru yang melakukan absen
        'status', // Hadir, Izin, Sakit, Cuti
        'proof', // Link Google Drive
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
