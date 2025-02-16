<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    /**
     * Relasi ke model Student.
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
}
