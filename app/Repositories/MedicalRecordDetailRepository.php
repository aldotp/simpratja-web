<?php

namespace App\Repositories;

use App\Models\MedicalRecordDetail;

class MedicalRecordDetailRepository
{
    /**
     * Retrieve all medical record details.
     * @returns {Array<MedicalRecordDetail>} List of all medical record details.
     */
    public function getAll()
    {
        return MedicalRecordDetail::all();
    }

    /**
     * Retrieve medical record detail by ID.
     * @param {number} id - The ID of the medical record detail.
     * @returns {MedicalRecordDetail|null} The medical record detail instance or null if not found.
     */
    public function getById($id)
    {
        return MedicalRecordDetail::find($id);
    }

    /**
     * Store medical record detail data.
     * @param {Object} data - The medical record detail data to store.
     * @returns {MedicalRecordDetail} The created medical record detail instance.
     */
    public function store($data)
    {
        return MedicalRecordDetail::create($data);
    }

    /**
     * Update medical record detail by ID.
     * @param {number} id - The ID of the medical record detail.
     * @param {Object} data - The data to update.
     * @returns {MedicalRecordDetail|null} The updated medical record detail instance or null if not found.
     */
    public function update($id, $data)
    {
        $detail = MedicalRecordDetail::find($id);
        if (!$detail) {
            return null;
        }
        $detail->update($data);
        return $detail;
    }

    /**
     * Delete medical record detail by ID.
     * @param {number} id - The ID of the medical record detail.
     * @returns {MedicalRecordDetail|null} The deleted medical record detail instance or null if not found.
     */
    public function delete($id)
    {
        $detail = MedicalRecordDetail::find($id);
        if ($detail) {
            $detail->delete();
            return $detail;
        }
        return null;
    }

    /**
     * Query medical record details based on conditions.
     * @param {Object} conditions - The conditions to query medical record details.
     * @returns {Array<MedicalRecordDetail>} List of medical record details matching conditions.
     */
    public function queryWhere($conditions)
    {
        $query = MedicalRecordDetail::query();
        foreach ($conditions as $field => $value) {
            $query->where($field, $value);
        }
        return $query->get();
    }

    public function query()
    {
        return MedicalRecordDetail::query();
    }

}