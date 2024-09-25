<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $connection = 'pgsql_gateway';
    protected $table = 'students';
    public $timestamps = false;
}
