<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    use HasFactory;
    protected $connection = 'pgsql_gateway';
    protected $tabel = 'users';

    protected $hidden = [
        'password',
    ];
}
