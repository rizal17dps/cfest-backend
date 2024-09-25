<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    use HasFactory;
    protected $connection = 'pgsql_gateway';
    protected $table = 'master_of_works';
    public $timestamps = false;
}
