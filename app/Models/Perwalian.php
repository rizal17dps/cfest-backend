<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perwalian extends Model
{
    use HasFactory;
    protected $connection = 'pgsql_gateway';
    protected $table = 'student_advisory';
    public $timestamps = false;

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'lecture_id', 'id');
    }
}
