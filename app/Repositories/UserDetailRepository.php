<?php

namespace App\Repositories;

use App\Models\UserDetail;
use Illuminate\Support\Facades\DB;

class UserDetailRepository
{
    public function getAll($filters = [])
    {
        $query = UserDetail::query();

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('phone_number', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query->get();
    }

    public function getById($id)
    {
        return UserDetail::find($id);
    }

    public function getByUserId($userId)
    {
         return UserDetail::query()->where('user_id', $userId)->first();
    }

    public function store($data)
    {
        return UserDetail::create($data);
    }

    public function update($id, $data)
    {
        $docter = UserDetail::find($id);
        if (!$docter) {
            return null;
        }
        $docter->update($data);
        return $docter;
    }

    public function delete($id)
    {
        $userDetail = UserDetail::find($id);
        if (!$userDetail) {
            return null;
        }
        $userDetail->delete();
        return $userDetail;
    }

    public function countPatientsByDoctor($doctorId)
    {
        return DB::table('visits')
            ->where('docter_id', $doctorId)
            ->distinct('patient_id')
            ->count('patient_id');
    }


}
