<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Medical_Record extends Model
{
    protected $table = 'medical_records';

    protected $fillable = [
        'patient_id',
        'medical_record_number',
    ];


    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class, 'patient_id', 'id');
    }
}