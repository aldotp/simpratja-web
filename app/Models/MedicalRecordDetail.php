<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecordDetail extends Model
{
    use HasFactory;

    protected $table = 'medical_records_details';

    protected $fillable = [
        'medical_record_id',
        'docter_id',
        'patient_id',
        'visit_id',
        'medicine_id',
        'examination_date',
        'complaint',
        'diagnosis',
    ];

    // Relasi ke MedicalRecord
    public function medicalRecord()
    {
        return $this->belongsTo(Medical_Record::class, 'medical_record_id');
    }

    // Relasi ke Doctor
    public function docter()
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }

    // Relasi ke Visit
    public function visit()
    {
        return $this->belongsTo(Visit::class, 'visit_id');
    }

    // Relasi ke Medicine
    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id');
    }
}
