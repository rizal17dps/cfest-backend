<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MappingMahasiswa extends Model
{
    use HasFactory;
    protected $connection = 'pgsql_gateway';
    protected $table = 'academic_program_students';
    public $timestamps = false;

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'academic_program_id', 'id');
    }
}
