<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    use HasFactory;

    protected $fillable = ['agenda_id', 'student_id', 'status'];

    /**
     * Relasi ke Agenda (penanda tanggal dari jadwal pelajaran).
     */
    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }

    /**
     * Relasi ke Student.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
