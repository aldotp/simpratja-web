<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $table = 'user_details';

    protected $fillable = [
        'name',
        'nik',
        'gender',
        'phone_number',
        'quota',
        'user_id'
    ];
}