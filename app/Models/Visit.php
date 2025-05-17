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

    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class, 'patient_id');
    }

    public function docter()
    {
        return $this->belongsTo(\App\Models\UserDetail::class, 'docter_id');
    }
}
