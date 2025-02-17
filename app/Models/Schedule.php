<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'grade_id',
        'user_id',
        'day',
        'start_time',
        'end_time',
    ];

    // Relasi ke Lesson (Mata Pelajaran)
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    // Relasi ke Grade (Kelas)
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    // Relasi ke User (Guru)
    public function teacher()
    {
        return $this->belongsTo(User::class, 'user_id')->where('role', 'Guru');
    }

    // Relasi ke User (Semua)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
