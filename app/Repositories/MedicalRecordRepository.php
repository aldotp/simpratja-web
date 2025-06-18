<?php

namespace App\Repositories;

use App\Models\Medical_Record;
use Illuminate\Support\Facades\DB;

class MedicalRecordRepository
{
    /**
     * Retrieve all medical records.
     * @returns {Array<Medical_Record>} List of all medical records.
     */
    public function getAll()
    {
        return Medical_Record::all();
    }

    /**
     * Retrieve medical record by ID.
     * @param {number} id - The ID of the medical record.
     * @returns {Medical_Record|null} The medical record instance or null if not found.
     */
    public function getById($id)
    {
        return Medical_Record::find($id);
    }

    /**
     * Store a new medical record.
     * @param {Array} data - The data for creating a new medical record.
     * @returns {Medical_Record} The created medical record instance.
     */
    public function store($data)
    {
        return Medical_Record::create($data);
    }

    /**
     * Update an existing medical record.
     * @param {number} id - The ID of the medical record to update.
     * @param {Array} data - The updated data for the medical record.
     * @returns {Medical_Record|null} The updated medical record instance or null if not found.
     */
    public function update($id, $data)
    {
        $record = Medical_Record::find($id);
        if (!$record) {
            return null;
        }
        $record->update($data);
        return $record;
    }


    /**
     * Retrieve all medical records.
     * @returns {Array<Medical_Record>} List of all medical records.
     */
    public function getAllMedicalRecords()
    {
        return DB::table('medical_records as mr')
            ->join('patients as p', 'mr.patient_id', '=', 'p.id')
            ->select('mr.id as medical_record_id', 'mr.medical_record_number', 'p.id as patient_id', 'p.name as patient_name', 'p.nik as patient_nik', 'mr.created_at')
            ->groupBy('mr.id', 'p.id', 'p.name', 'p.nik', 'mr.created_at')
            ->get();
    }

    /**
     * Retrieve medical record details by patient ID.
     * @param {number} patientId - The ID of the patient.
     * @returns {Array<Object>} List of medical record details for the patient.
     */
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
