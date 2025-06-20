<?php

namespace App\Services;

use App\Repositories\PatientRepository;
use App\Repositories\VisitRepository;
use App\Repositories\UserDetailRepository;
use App\Repositories\FeedbackRepository;
use App\Repositories\UserRepository;
use App\Repositories\MedicalRecordRepository;
use Illuminate\Support\Facades\DB;

class StaffService
{
    protected $patientRepository;
    protected $visitRepository;
    protected $userDetailRepository;
    protected $userRepository;
    protected $feedbackRepository;
    protected $medicalRecordRepository;

    public function __construct(PatientRepository $patientRepository, VisitRepository $visitRepository, UserDetailRepository $userDetailRepository, FeedbackRepository $feedbackRepository, UserRepository $userRepository, MedicalRecordRepository $medicalRecordRepository)
    {
        $this->patientRepository = $patientRepository;
        $this->visitRepository = $visitRepository;
        $this->userDetailRepository = $userDetailRepository;
        $this->feedbackRepository = $feedbackRepository;
        $this->userRepository = $userRepository;
        $this->medicalRecordRepository = $medicalRecordRepository;
    }


    /**
     * Validate register patient
     *
     * @param int $id
     * @return array
     */
    public function ValidateRegisterPatient($id)
    {
        return DB::transaction(function () use ($id) {

            $visit = $this->visitRepository->queryWhere(['id' =>$id])->first();
            if (!$visit) {
                return null;
            }

            $existNumber = $this->medicalRecordRepository->query()->where('patient_id', $visit->patient_id)->select("medical_record_number");
            if (!$existNumber->exists()) {
                 $this->medicalRecordRepository->store([
                    'patient_id' => $visit->patient_id,
                    'medical_record_number' => $this->generateMedicalRecordNumber(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if ($visit->visit_status !== 'register') {
                return[
                    'queue_number' => $visit->queue_number,
                    'visit_status' => $visit->visit_status
                 ];
            }

            $docter = $this->userRepository->getAllUsersDetailByID($visit['docter_id']);
            if (!$docter) {
                return null;
            }

            $visitCount = $this->visitRepository->getLatestQueueNumber($visit['docter_id'], $visit['examination_date']);
            if ($visitCount >= $docter->quota) {
                return null;
            }

            $queueNumber = $visitCount + 1;

            $visitData = [
                'queue_number' => $queueNumber,
                'visit_status' => 'queue',
            ];

            $updateVisit = $this->visitRepository->update($visit->id,$visitData);
            if (!$updateVisit) {
               return null;
            }


            $response = [
                'queue_number' => $queueNumber,
                'visit_status' => $visit->visit_status,
            ];

            return $response;
        });
    }

    /**
     * Register existing patient visit
     *
     * @param array $data
     * @return array
     */
    public function registerExistingPatientVisit($data)
    {
        DB::beginTransaction();

        try {
            $existingPatient = $this->patientRepository->queryWhere(["id" => $data["patient_id"]])->first();
            if ($existingPatient) {
                $existingVisit = $this->visitRepository->queryWhere(['patient_id' => $existingPatient->id])
                    ->where('examination_date', $data['visit_date'])
                    ->first();
                if ($existingVisit) {
                    return [null, 'Patient already has a visit for this date'];
                }
            }


            $docter = $this->userRepository->getAllUsersDetailByID($data['docter_id']);
            if (!$docter) {
                return [null, 'docter not found'];
            }

            $visitData = [
                'patient_id' => $data['patient_id'],
                'examination_date' => $data['visit_date'],
                'status' => 'pending',
                'docter_id' => $data['docter_id'],
                'registration_number' => $this->generateRegistrationNumber($data['visit_date'], $data['docter_id']),
                'queue_number' => 0,
                'visit_status' => 'register',
            ];

            $visit = $this->visitRepository->store($visitData);

            DB::commit();
            return $visit;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Get patient by ID
     *
     * @param int $id
     * @return array
     */
    public function getByID($id)
    {
        return $this->patientRepository->getByID($id);
    }

    /**
     * Get all patients
     *
     * @return array
     */
    public function getAll()
    {
        return $this->patientRepository->getAll();
    }

    /**
     * Count all patients
     *
     * @return int
     */
    public function countAll()
    {
        return $this->patientRepository->countAll();
    }

    /**
     * Update patient by ID
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update($id, $data)
    {
        return $this->patientRepository->update($id, $data);
    }

    /**
     * Delete patient by ID
     *
     * @param int $id
     * @return array
     */
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

    /**
     * Generate registration number
     *
     * @param string $visit_date
     * @param int $docter_id
     * @return string
     */
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

    public function getRegisByRegistrationIDandNIK($request)
    {
        $data = DB::table('patients')
            ->join('visits', 'patients.id', '=', 'visits.patient_id')
            ->join('users as docter_users', 'visits.docter_id', '=', 'docter_users.id')
            ->join('user_details as docter', 'docter_users.id', '=', 'docter.user_id')
            ->where('patients.nik', $request['nik'])
            ->where('visits.registration_number', $request['registration_number'])
            ->select(
                'patients.*',
                'visits.id as visit_id',
                'visits.docter_id as visit_docter_id',
                'visits.examination_date as visit_examination_date',
                'visits.insurance as visit_insurance',
                'visits.registration_number as visit_registration_number',
                'visits.queue_number as visit_queue_number',
                'visits.visit_status as visit_status',
                'docter.name as docter_name'
            )
            ->first();

        if (!$data) {
            return null;
        }

        return [
            'patient_id' => $data->id,
            'patient_name' => $data->name,
            'patient_nik' => $data->nik,
            'patient_gender' => $data->gender,
            'patient_phone_number' => $data->phone_number,
            'patient_address' => $data->address,
            'visit_id' => $data->visit_id,
            'visit_docter_id' => $data->visit_docter_id,
            'visit_examination_date' => $data->visit_examination_date,
            'visit_insurance' => $data->visit_insurance,
            'visit_registration_number' => $data->visit_registration_number,
            'visit_queue_number' => $data->visit_queue_number,
            'visit_status' => $data->visit_status,
            'docter_name' => $data->docter_name,
        ];
    }

    /**
     * Get registration by ID
     *
     * @param int $id
     * @return array
     */
    public function getRegistration($id)
    {
        $patient = $this->patientRepository->getByID($id);
        if (!$patient) {
            return null;
        }

        // Get the latest visit for this patient (or adjust as needed)
        $visit = $this->visitRepository->queryWhere(['patient_id' => $id])->orderBy('examination_date', 'desc')->first();

        if (!$visit) {
            return null;
        }

        return [
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
    }

    /**
     * Get all registrations
     *
     * @param array $request
     * @return array
     */
    public function getAllRegistration($request)
    {
        $query = $this->visitRepository->query()->with(['patient']);


        if (!empty($request['docter_name'])) {
            $query = $query->whereHas('docter', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request['docter_name'] . '%');
            });
        }


        if (!empty($request['start_date']) && !empty($request['end_date'])) {
            $query = $query->whereBetween('examination_date', [$request['start_date'], $request['end_date']]);
        } elseif (!empty($request['examination_date'])) {
            $query = $query->where('examination_date', $request['examination_date']);
        }

        $registrations = $query->get();

        return $registrations->map(function($visit) {
            return [
                'patient_id' => $visit->patient_id,
                'patient_name' => $visit->patient->name ?? null,
                'patient_nik' => $visit->patient->nik ?? null,
                'patient_gender' => $visit->patient->gender ?? null,
                'patient_phone_number' => $visit->patient->phone_number ?? null,
                'patient_address' => $visit->patient->address?? null,
                'visit_id' => $visit->id,
                'visit_docter_id' => $visit->docter_id,
                'visit_docter_name' => $visit->docter->name ?? null,
                'visit_examination_date' => $visit->examination_date,
                'visit_insurance' => $visit->insurance,
                'visit_registration_number' => $visit->registration_number,
                'visit_queue_number' => $visit->queue_number,
                'visit_status' => $visit->visit_status,
            ];
        });
    }

    /**
     * Delete registration by ID
     *
     * @param int $id
     * @return array
     */
    public function deleteRegistration($id)
    {
        $patient = $this->patientRepository->getByID($id);

        if (!$patient) {
            return null;
        }

        $patient->delete();

        return $patient;
    }

    /**
     * Generate medical record number
     *
     * @return string
     */
    public function generateMedicalRecordNumber()
    {
        $date = date('Ymd');
        $random = mt_rand(100, 999);
        return "MRN{$date}{$random}";
    }
}
