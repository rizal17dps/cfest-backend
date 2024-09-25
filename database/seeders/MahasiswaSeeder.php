<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $insert = new Mahasiswa();
        $insert->nim = "1234567";
        $insert->name = "Nama Mahasiswa 2";
        $insert->save();
    }
}
