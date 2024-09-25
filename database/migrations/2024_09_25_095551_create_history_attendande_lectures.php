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
        Schema::create('history_attendance_lectures', function (Blueprint $table) {
            $table->id();
            $table->integer('schedule_id');
            $table->integer('lecture_id');
            $table->dateTime('presensi_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_attendance_lectures');
    }
};
