<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patients';

    protected $fillable = [
        'nik',
        'name',
        'birth_date',
        'gender',
        'blood_type',
        'religion',
        'status',
        'address',
        'phone_number',
    ];
}