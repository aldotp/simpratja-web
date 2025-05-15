<?php

namespace App\Services;

use App\Repositories\VisitRepository;
use App\Repositories\DocterRepository;
use Illuminate\Support\Facades\DB;

class VisitService
{
    protected $visitRepository;
    protected $docterRepository;

    public function __construct(VisitRepository $visitRepository, DocterRepository $docterRepository)
    {
        $this->visitRepository = $visitRepository;
        $this->docterRepository = $docterRepository;
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

        $visit->visit_status = 2;
        $visit->save();

        return $visit;
    }

    public function countAll()
    {
        return $this->visitRepository->countAll();
    }

    public function registerExistingPatientVisit($data)
    {
        DB::beginTransaction();
        
        try {
            $docter = $this->docterRepository->getById($data['docter_id']);
            if (!$docter) {
                return [null, null, 'Dokter tidak ditemukan'];
            }


            $visitCount = $this->visitRepository->countVisitsByDocterAndDate($data['docter_id'], $data['visit_date']);

            if ($visitCount >= $docter->quota) {
                return [null, null, 'Kuota dokter sudah penuh untuk tanggal tersebut'];
            }
    
            $queueNumber = $visitCount + 1;


            $visitData = [
                'patient_id' => $data['patient_id'],
                'examination_date' => $data['visit_date'],
                'complaint' => $data['complaint'],
                'status' => 'pending',
                'docter_id' => $data['docter_id'],
                'insurance' => $data['insurance'],
                'registration_number' => $this->generateRegistrationNumber($data['visit_date'], $data['docter_id']),
                'queue_number' => $queueNumber,
                'visit_status' => 1,
            ];

            $visit = $this->visitRepository->store($visitData);
            
            DB::commit();
            return $visit;
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function generateRegistrationNumber($visit_date, $docter_id)
    {
        $kodeKunjungan = 1;

        $conditions = [
            'examination_date' => $visit_date,
            'docter_id' => $docter_id,
        ];

        $count = $this->visitRepository->queryWhere($conditions)->count();
        $nomorUrut = $count + 1;

        return "REG/{$kodeKunjungan}/{$visit_date}/{$nomorUrut}";
    }
}