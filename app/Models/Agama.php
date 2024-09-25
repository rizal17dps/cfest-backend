<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agama extends Model
{
    use HasFactory;
    protected $connection = 'pgsql_gateway';
    protected $table = 'master_of_religions';
    public $timestamps = false;
}
