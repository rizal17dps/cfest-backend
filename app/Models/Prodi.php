<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;
    protected $connection = 'pgsql_gateway';
    protected $table = 'academic_programs';
    public $timestamps = false;
}
