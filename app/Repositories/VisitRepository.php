<?php

namespace App\Repositories;

use App\Models\Visit;

class VisitRepository
{
    public function store($data)
    {
        return Visit::create($data);
    }

    public function getVisit($id)
    {
        return Visit::find($id);
    }

    public function getQueueNumber($id)
    {
        $visit = Visit::find($id);
        return $visit ? $visit->queue_number : null;
    }

    public function getByID($id)
    {
         return Visit::find($id);
    }

    public function getAll($filters = [])
    {
        $query = Visit::query()
            ->join('patients', 'visits.patient_id', '=', 'patients.id')
            ->join('user_details', 'visits.docter_id', '=', 'user_details.user_id')
            ->select('visits.id','patients.id as patient_id','user_details.name as doctor_name','patients.name as patient_name', 'patients.nik as patient_nik', 'patients.phone_number as patient_phone_number','visits.examination_date', 'visits.insurance', 'visits.registration_number', 'visits.queue_number', 'visits.visit_status', 'visits.created_at', 'visits.updated_at');

        if (!empty($filters['date'])) {
            $query->where('visits.examination_date', $filters['date']);
        }

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('patients.name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('patients.nik', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('patients.phone_number', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query->get();
    }

    public function getVisitByID($id)
    {
        $query = Visit::query()
            ->join('patients', 'visits.patient_id', '=', 'patients.id')
            ->join('user_details', 'visits.docter_id', '=', 'user_details.user_id')
            ->select('visits.id','user_details.name as doctor_name','patients.name as patient_name', 'patients.nik as patient_nik', 'patients.phone_number as patient_phone_number','visits.examination_date', 'visits.insurance', 'visits.registration_number', 'visits.queue_number', 'visits.visit_status', 'visits.created_at', 'visits.updated_at')
            ->where('visits.id', $id);

            $data = $query->first();
            if ($data) {
                return $data;
            } else {
                return null;
            }

    }


    public function countVisitsByDocterAndDate($docterId, $examinationDate)
    {
        return Visit::where('docter_id', $docterId)
            ->where('examination_date', $examinationDate)
            ->count();
    }

    public function countAll()
    {
        return Visit::count();
    }

    public function query()
    {
        return \App\Models\Visit::query();
    }

    public function queryWhere($conditions)
    {
        $query = Visit::query();

        foreach ($conditions as $field => $value) {
            $query->where($field, $value);
        }

        return $query;
    }

    public function delete($id)
    {
        $visit = Visit::find($id);
        $visit->delete();
        return $visit;
    }
}
