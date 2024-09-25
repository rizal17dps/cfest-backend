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
        Schema::create('mahasiswa_pt', function (Blueprint $table) {
            $table->id();
            $table->integer('collage_id');
            $table->integer('student_id');
            $table->integer('academic_program_id');
            $table->string('nim');
            $table->date('tgl_masuk');
            $table->date('tgl_keluar')->nullable();
            $table->string('no_ijazah')->nullable();
            $table->string('no_transkrip')->nullable();
            $table->string('status_keluar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa_pt');
    }
};
