<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docter extends Model
{
    protected $table = 'docters';

    protected $fillable = [
        'name',
        'nik',
        'gender',
        'phone_number',
        'quota',
        'user_id'
    ];
}