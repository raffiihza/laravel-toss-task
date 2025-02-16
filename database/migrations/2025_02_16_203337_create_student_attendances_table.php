<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agenda_id')->constrained()->onDelete('cascade'); // Relasi ke agenda (penanda tanggal jadwal mingguan)
            $table->foreignId('student_id')->constrained()->onDelete('cascade'); // Relasi ke siswa
            $table->enum('status', ['Hadir', 'Izin', 'Sakit', 'Alfa']); // Status presensi siswa
            $table->timestamps(); // Waktu pencatatan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_attendances');
    }
};
