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

    /**
     * Get all visits for the patient
     */
    public function visits()
    {
        return $this->hasMany(Visit::class, 'patient_id');
    }

    /**
     * Get the medical record associated with the patient
     */
    public function medicalRecord()
    {
        return $this->belongsTo(Medical_Record::class, 'id', 'patient_id');
    }

    /**
     * Get all feedbacks from the patient
     */
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'patient_id');
    }
}
