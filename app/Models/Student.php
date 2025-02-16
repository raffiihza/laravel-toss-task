<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['nisn', 'name', 'gender', 'class_id']; // Memungkinkan mass assignment

    /**
     * Relasi ke model Grade (kelas).
     */
    public function grade()
    {
        return $this->belongsTo(Grade::class, 'class_id');
    }
}
