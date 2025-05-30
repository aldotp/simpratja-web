<?php

namespace App\Repositories;

use App\Models\Visit;

class VisitRepository
{
    public function store($data)
    {
        return Visit::create($data);
    }

    public function update($id, $data)
    {
        return Visit::find($id)->update($data);
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
            ->select('visits.id','patients.id as patient_id','user_details.name as doctor_name','patients.name as patient_name', 'patients.nik as patient_nik', 'patients.phone_number as patient_phone_number','visits.examination_date', 'visits.registration_number', 'visits.queue_number', 'visits.visit_status', 'visits.created_at', 'visits.updated_at');

        if (!empty($filters['date'])) {
            $query->where('visits.examination_date', $filters['date']);
        }

        // Filter by date range if provided
        if (!empty($filters['start_date'])) {
            $query->where('visits.examination_date', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->where('visits.examination_date', '<=', $filters['end_date']);
        }

        if (!empty($filters['visit_status'])) {
            $query->whereIn('visits.visit_status', $filters['visit_status']);
        }

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('patients.name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('patients.nik', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('patients.phone_number', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (!empty($filters['docter_id'])) {
            $query->where('visits.docter_id', $filters['docter_id']);
        }

        $query= $query->orderBy('visits.examination_date', 'desc');

        return $query->get();
    }

       public function getVisitByID($id)
    {
        $query = Visit::query()
            ->leftjoin('patients', 'visits.patient_id', '=', 'patients.id')
            ->leftjoin('user_details', 'visits.docter_id', '=', 'user_details.user_id')
            ->leftjoin('medical_records_details', 'visits.id', '=', 'medical_records_details.visit_id')
            ->leftjoin('medicines', 'medicines.id', '=', 'medical_records_details.medicine_id')
            ->select('visits.id','user_details.name as doctor_name','patients.name as patient_name', 'patients.nik as patient_nik', 'patients.phone_number as patient_phone_number','visits.examination_date', 'visits.registration_number', 'visits.queue_number', 'visits.visit_status', 'visits.created_at', 'visits.updated_at', 'medical_records_details.complaint', 'medical_records_details.diagnosis', 'medicines.name as medicine_name' )
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


    public function getLatestQueueNumber($docterId, $examinationDate)
    {
        return Visit::where('docter_id', $docterId)
            ->where('examination_date', $examinationDate)
            ->max('queue_number');
    }

    public function countAll()
    {
        return Visit::count();
    }

    public function query()
    {
        return Visit::query();
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
