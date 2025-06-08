<?php

namespace App\Services;

use App\Repositories\VisitRepository;
use App\Repositories\UserDetailRepository;
use App\Repositories\UserRepository;
use App\Repositories\PatientRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitService
{
    protected $visitRepository;
    protected $userDetailRepository;
    protected $userRepository;
    protected $patientRepository;

    public function __construct(VisitRepository $visitRepository, UserDetailRepository $userDetailRepository, UserRepository $userRepository, PatientRepository $patientRepository)
    {
        $this->visitRepository = $visitRepository;
        $this->userDetailRepository = $userDetailRepository;
        $this->userRepository = $userRepository;
        $this->patientRepository = $patientRepository;
    }

    public function getQueueNumber($id)
    {
        return $this->visitRepository->getQueueNumber($id);
    }

    public function getAllVisits($filters = [])
    {
        // Ensure filters is an array
        if (!is_array($filters)) {
            $filters = [];
        }

        return $this->visitRepository->getAll($filters);
    }

    public function getVisitById($id)
    {
        return $this->visitRepository->getVisitByID($id);
    }

    public function validateVisits($id)
    {
        $visit = $this->visitRepository->getById($id);

        if (!$visit) {
            throw new \Exception('Visit not found');
        }

        $visit->visit_status = 'queue';
        $visit->save();

        return $visit;
    }

    public function countAll()
    {
        return $this->visitRepository->countAll();
    }


    public function checkStatusVisit($request)
    {
        $visit = $this->visitRepository->queryWhere(['patient_id' => $request['patient_id'], 'visit_status' => 'done', 'examination_date' => $request['examination_date'] ])->first();

        if (!$visit) {
            return null;
        }

        return $visit;
    }

     public function callPatient($id)
    {

        return DB::transaction(function () use ($id) {

            $visit = $this->visitRepository->getById($id);
            if (!$visit) {
                return [null, 'Visit not found'];
            }


            $updateData =  $this->visitRepository->update($visit->id, ['visit_status' => 'check']);


            if ($updateData) {
                return null;
            }

            $response = [
                'visit_status'=> $updateData->visit_status
            ];

            return $response;
        });
    }
}
