<?php

namespace App\Services;

use App\Repositories\PatientRepository;
use App\Repositories\VisitRepository;
use App\Repositories\DocterRepository;
use App\Repositories\FeedbackRepository;

class PatientService
{
    protected $patientRepository;
    protected $visitRepository;
    protected $docterRepository;
    protected $feedbackRepository;

    public function __construct(PatientRepository $patientRepository, VisitRepository $visitRepository, DocterRepository $docterRepository, FeedbackRepository $feedbackRepository)
    {
        $this->patientRepository = $patientRepository;
        $this->visitRepository = $visitRepository;
        $this->docterRepository = $docterRepository;
        $this->feedbackRepository = $feedbackRepository;
    }


    public function registerPatientWithVisit($data)
    {
        $docter = $this->docterRepository->getById($data['docter_id']);
        if (!$docter) {
            return [null, null, 'docter not found'];
        }

        $visitCount = $this->visitRepository->countVisitsByDocterAndDate($data['docter_id'], $data['examination_date']);


        if ($visitCount >= $docter->quota) {
            return [null, null, 'quota is full'];
        }

        $queueNumber = $visitCount + 1;

        $patient = $this->patientRepository->store($data);

        $visitData = [
            'patient_id' => $patient->id,
            'docter_id' => $data['docter_id'],
            'examination_date' => $data['examination_date'],
            'insurance' => $data['insurance'],
            'registration_number' => $this->generateRegistrationNumber($data['examination_date']),
            'queue_number' => $queueNumber,
            'visit_status' => '1',
        ];
        $visit = $this->visitRepository->store($visitData);

        $response = [
            'patient_id' => $patient->id,
            'patient_name' => $patient->name,
            'patient_nik' => $patient->nik,
            'patient_gender' => $patient->gender,
            'patient_phone_number' => $patient->phone_number,
            'visit_id' => $visit->id,
            'visit_docter_id' => $visit->docter_id,
            'visit_examination_date' => $visit->examination_date,
            'visit_insurance' => $visit->insurance,
            'visit_registration_number' => $visit->registration_number,
            'visit_queue_number' => $visit->queue_number,
            'visit_status' => $visit->visit_status,
        ];

        return [$response, null];
    }

    public function getByID($id)
    {
        return $this->patientRepository->getByID($id);
    }

    public function getAll()
    {
        return $this->patientRepository->getAll();
    }

    public function countAll()
    {
        return $this->patientRepository->countAll();
    }

    public function update($id, $data)
    {
        return $this->patientRepository->update($id, $data);
    }

    public function deletePatient($id)
    {
        $patient = $this->patientRepository->getByID($id);
        if (!$patient) {
            return 'data not found';
        }


        $feedbacks = $this->feedbackRepository->queryWhere(['patient_id' => $id]);

        if ($feedbacks->count() > 0) {
            foreach ($feedbacks as $feedback) {
                $this->feedbackRepository->delete($feedback->id);
            }
        }

        $visits = $this->visitRepository->queryWhere(['patient_id' => $id])->get();

        if ($visits->count() > 0) {
            foreach ($visits as $visit) {
                $this->visitRepository->delete($visit->id);
            }
        }


        $patient = $this->patientRepository->delete($id);

        return $patient;
    }

    public function generateRegistrationNumber($examinationDate)
    {
        $kodeKunjungan = 1;

        $count = $this->visitRepository->queryWhere(['examination_date' => $examinationDate])->count();
        $nomorUrut = $count + 1;

        return "REG/{$kodeKunjungan}/{$examinationDate}/{$nomorUrut}";
    }

}