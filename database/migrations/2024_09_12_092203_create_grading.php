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
        Schema::create('grading', function (Blueprint $table) {
            $table->id();
            $table->integer('collage_id');
            $table->integer('min');
            $table->integer('max');
            $table->string('grade');
            $table->float('bobot', 4, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grading');
    }
};
