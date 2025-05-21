<?php

namespace App\Repositories;

use App\Models\MedicalRecordDetail;

class MedicalRecordDetailRepository
{
    public function getAll()
    {
        return MedicalRecordDetail::all();
    }

    public function getById($id)
    {
        return MedicalRecordDetail::find($id);
    }

    public function store($data)
    {
        return MedicalRecordDetail::create($data);
    }

    public function update($id, $data)
    {
        $detail = MedicalRecordDetail::find($id);
        if (!$detail) {
            return null;
        }
        $detail->update($data);
        return $detail;
    }

    public function delete($id)
    {
        $detail = MedicalRecordDetail::find($id);
        if ($detail) {
            $detail->delete();
            return $detail;
        }
        return null;
    }

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