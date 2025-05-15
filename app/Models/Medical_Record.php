<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medical_Record extends Model
{
    protected $table = 'medical_records';

    protected $fillable = [
        'patient_id',
        'medical_record_number',
    ];
}
