<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;
    protected $connection = 'pgsql_gateway';
    protected $table = 'semester';
    public $timestamps = false;
}
