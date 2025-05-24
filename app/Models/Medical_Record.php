<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medical_Record extends Model
{
    protected $table = 'medical_records';

    protected $fillable = [
        'patient_id',
        'medical_record_number',
    ];

    /**
     * Get the patient that owns the medical record
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    /**
     * Get all medical record details for this medical record
     */
    public function details(): HasMany
    {
        return $this->hasMany(MedicalRecordDetail::class, 'medical_record_id');
    }
}
