<?php

namespace App\Services;

use App\Repositories\VisitRepository;
use App\Repositories\UserDetailRepository;
use App\Repositories\UserRepository;
use App\Repositories\PatientRepository;
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
            return [null, 'Visit not found'];
        }

        $visit->visit_status = 'queue';
        $visit->save();

        return $visit;
    }

    public function countAll()
    {
        return $this->visitRepository->countAll();
    }

}
