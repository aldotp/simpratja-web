<?php
namespace App\Repositories;

use App\Models\Patient;

class PatientRepository
{
    public function query()
    {
        return Patient::query();
    }

    public function store($data) {
        return Patient::create($data);
    }
    public function getByID($id) {
        return Patient::find($id);
    }
    public function getAll()
    {
        return Patient::all();
    }
    public function countAll()
    {
        return Patient::count();
    }

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

    public function delete($id)
    {
        $patient = Patient::find($id);
        $patient->delete();
        return $patient;
    }
}
