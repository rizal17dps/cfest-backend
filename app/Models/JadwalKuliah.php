<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKuliah extends Model
{
    use HasFactory;
    protected $connection = 'pgsql_gateway';
    protected $table = 'course_schedules';
    public $timestamps = false;

    public function universitas()
    {
        return $this->belongsTo(Universitas::class, 'collage_id', 'id');
    }
    
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'faculty_id', 'id');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'academic_id', 'id');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'room_id', 'id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'lecture_id', 'id');
    }

    public function matkul()
    {
        return $this->belongsTo(Matkul::class, 'course_id', 'id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }
}
