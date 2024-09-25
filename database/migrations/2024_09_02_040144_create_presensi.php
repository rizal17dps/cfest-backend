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
        Schema::create('presensi', function (Blueprint $table) {
            $table->id();
            $table->integer('faculty_id');
            $table->integer('academic_id');
            $table->integer('schedule_id');
            $table->integer('lecturer_id');
            $table->integer('start');
            $table->integer('end');
            $table->string('code');
            $table->string('path');
            $table->boolean('check');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};
