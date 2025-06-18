<?php

namespace App\Repositories;

use App\Models\Visit;
use Carbon\Carbon;

class VisitRepository
{
    /**
     * Store visit data.
     * @param {Object} data - The visit data to store.
     * @returns {Visit} The created visit instance.
     */
    public function store($data)
    {
        return Visit::create($data);
    }

    /**
     * Update visit by ID.
     * @param {number} id - The ID of the visit.
     * @param {Object} data - The data to update.
     * @returns {Visit|null} The updated visit instance or null if not found.
     */
    public function update($id, $data)
    {
        return Visit::find($id)->update($data);
    }

    /**
     * Retrieve visit by ID.
     * @param {number} id - The ID of the visit.
     * @returns {Visit|null} The visit instance or null if not found.
     */
    public function getVisit($id)
    {
        return Visit::find($id);
    }

    /**
     * Get queue number by ID.
     * @param {number} id - The ID of the visit.
     * @returns {number|null} The queue number or null if not found.
     */
    public function getQueueNumber($id)
    {
        $visit = Visit::find($id);
        return $visit ? $visit->queue_number : null;
    }
    /**
     * Get visit by ID.
     * @param {number} id - The ID of the visit.
     * @returns {Visit|null} The visit instance or null if not found.
     */
    public function getByID($id)
    {
         return Visit::find($id);
    }

    /**
     * Get all visit.
     * @param {Object} filters - The filters to apply.
     * @returns {Array<Visit>} List of all visit.
     */
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

    /**
     * Count visits by docter and date.
     * @param {number} docterId - The ID of the docter.
     * @param {string} examinationDate - The examination date.
     * @returns {number} The count of visits.
     */
    public function countVisitsByDocterAndDate($docterId, $examinationDate)
    {
        return Visit::where('docter_id', $docterId)
            ->where('examination_date', $examinationDate)
            ->count();
    }


    /**
     * Get latest queue number by docter and date.
     * @param {number} docterId - The ID of the docter.
     * @param {string} examinationDate - The examination date.
     * @returns {number|null} The latest queue number or null if not found.
     */
    public function getLatestQueueNumber($docterId, $examinationDate)
    {
        return Visit::where('docter_id', $docterId)
            ->where('examination_date', $examinationDate)
            ->max('queue_number');
    }

    /**
     * Count all visit.
     * @returns {number} The total number of visit.
     */
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

    /**
     * Delete visit by ID.
     * @param {number} id - The ID of the visit.
     * @returns {Visit|null} The deleted visit instance or null if not found.
     */
    public function delete($id)
    {
        $visit = Visit::find($id);
        $visit->delete();
        return $visit;
    }

    /**
     * Count patient visit today.
     * @returns {number} The count of patient visit today.
     */
    public function countPatientToday()
    {
        $today = Carbon::today();
        return Visit::whereDate('created_at', $today)->count();
    }
}
