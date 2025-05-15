<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $table = 'medicines';

    protected $fillable = [
        'name',
        'unit',
        'price',
        'stock',
        'expiry_date',
    ];
}
