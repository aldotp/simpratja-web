<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    /**
     * Get all medical record details that use this medicine
     */
    public function medicalRecordDetails(): HasMany
    {
        return $this->hasMany(MedicalRecordDetail::class, 'medicine_id');
    }
}
