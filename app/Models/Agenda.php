<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = ['schedule_id', 'content'];

    /**
     * Relasi ke Schedule.
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
