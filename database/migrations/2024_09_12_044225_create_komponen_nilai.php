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
        Schema::create('komponen_nilai', function (Blueprint $table) {
            $table->id();
            $table->integer('kelas_kuliah_id');
            $table->integer('tugas');
            $table->integer('presentasi');
            $table->integer('quiz');
            $table->integer('uts');
            $table->integer('uas');
            $table->integer('praktikum');
            $table->integer('kelompok');
            $table->integer('kehadiran');
            $table->integer('sikap');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komponen_nilai');
    }
};
