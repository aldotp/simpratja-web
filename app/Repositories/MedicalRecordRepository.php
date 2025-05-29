<?php

namespace App\Repositories;

use App\Models\Medical_Record;
use Illuminate\Support\Facades\DB;

class MedicalRecordRepository
{
    public function getAll()
    {
        return Medical_Record::all();
    }

    public function getById($id)
    {
        return Medical_Record::find($id);
    }

    public function store($data)
    {
        return Medical_Record::create($data);
    }

    public function update($id, $data)
    {
        $record = Medical_Record::find($id);
        if (!$record) {
            return null;
        }
        $record->update($data);
        return $record;
    }


    public function getAllMedicalRecords()
    {
        return DB::table('medical_records as mr')
            ->join('patients as p', 'mr.patient_id', '=', 'p.id')
            ->select('mr.id as medical_record_id', 'mr.medical_record_number', 'p.id as patient_id', 'p.name as patient_name', 'p.nik as patient_nik', 'mr.created_at')
            ->groupBy('mr.id', 'p.id', 'p.name', 'p.nik', 'mr.created_at')
            ->get();
    }

    public function getMedicalRecordDetailByPatientID($patientId)
    {
        return DB::table('medical_records as mr')
            ->join('medical_records_details as mrd', 'mr.id', '=', 'mrd.medical_record_id')
            ->join('patients as p', 'mr.patient_id', '=', 'p.id')
            ->join('medicines as m', 'mrd.medicine_id', '=', 'm.id')
            ->where('mr.patient_id', $patientId)
            ->select(
                'mr.medical_record_number',
                'p.name as patient_name',
                'p.address as patient_address',
                'mrd.complaint',
                'mrd.examination_date',
                'mrd.diagnosis',
                'm.name as medicines'
            )
            ->get();
    }

    public function query()
    {
        return Medical_Record::query();
    }
}
