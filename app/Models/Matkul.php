<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matkul extends Model
{
    use HasFactory;
    protected $connection = 'pgsql_gateway';
    protected $table = 'courses';
    public $timestamps = false;
}
