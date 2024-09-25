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
        Schema::create('tugas_kuliah', function (Blueprint $table) {
            $table->id();
            $table->integer('kelas_kuliah_id');
            $table->integer('lecturer_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_kuliah');
    }
};
