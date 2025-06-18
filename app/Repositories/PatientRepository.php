<?php
namespace App\Repositories;

use App\Models\Patient;
use Illuminate\Support\Facades\DB;

class PatientRepository
{
    public function query()
    {
        return Patient::query();
    }

    /**
     * Create a new patient.
     * @param {Object} data - The data for creating the patient.
     * @returns {Patient} The newly created patient.
     */
    public function store($data) {
        return Patient::create($data);
    }
    /**
     * Retrieve patient by ID.
     * @param {number} id - The ID of the patient.
     * @returns {Patient|null} The patient instance or null if not found.
     */
    public function getByID($id)
    {
        return Patient::find($id);
    }
    /**
     * Retrieve all patients.
     * @returns {Array<Patient>} List of all patients.
     */
    public function getAll()
    {
        return Patient::all();
    }
    /**
     * Count all patients.
     * @returns {number} The total count of patients.
     */
    public function countAll()
    {
        return Patient::count();
    }
    /**
     * Update patient by ID.
     * @param {number} id - The ID of the patient.
     * @param {Object} data - The data for updating the patient.
     * @returns {Patient|null} The updated patient instance or null if not found.
     */
    public function update($id, $data)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return null;
        }

        $patient->update($data);
        return $patient;
    }
    public function queryWhere($conditions)
    {
        $query = Patient::query();

        foreach ($conditions as $field => $value) {
            $query->where($field, $value);
        }

        return $query->get();
    }

    /**
     * Delete patient by ID.
     * @param {number} id - The ID of the patient.
     * @returns {Patient|null} The deleted patient instance or null if not found.
     */
    public function delete($id)
    {
        $patient = Patient::find($id);
        $patient->delete();
        return $patient;
    }
}
