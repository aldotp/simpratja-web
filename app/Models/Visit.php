<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $table = 'visits';

    protected $fillable = [
        'patient_id',
        'docter_id',
        'examination_date',
        'insurance',
        'registration_number',
        'queue_number',
        'visit_status',
    ];
}
