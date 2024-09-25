<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    use HasFactory;
    protected $connection = 'pgsql_gateway';
    protected $table = 'master_of_educations';
    public $timestamps = false;
}
