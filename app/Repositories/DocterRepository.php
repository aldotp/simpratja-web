<?php

namespace App\Repositories;

use App\Models\Docter;
use Illuminate\Support\Facades\DB;

class DocterRepository
{
    public function getAll($filters = [])
    {
        $query = Docter::query();

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('nik', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('phone_number', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query->get();
    }

    public function getById($id)
    {
        return Docter::find($id);
    }

    public function getByUserId($userId)
    {
        return DB::table('docters')
            ->where('user_id', $userId)
            ->first();
    }

    public function store($data)
    {
        return Docter::create($data);
    }

    public function update($id, $data)
    {
        $docter = Docter::find($id);
        if (!$docter) {
            return null;
        }
        $docter->update($data);
        return $docter;
    }

    public function delete($id)
    {
        $docter = Docter::find($id);
        if (!$docter) {
            return null;
        }
        $docter->delete();
        return $docter;
    }

    public function countPatientsByDoctor($doctorId)
    {
        return DB::table('visits')
            ->where('docter_id', $doctorId)
            ->distinct('patient_id')
            ->count('patient_id');
    }
}