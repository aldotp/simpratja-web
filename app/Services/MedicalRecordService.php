<?php

namespace App\Services;

use App\Repositories\MedicalRecordRepository;
use App\Repositories\MedicalRecordDetailRepository;
use App\Repositories\UserDetailRepository;
use App\Repositories\VisitRepository;
use App\Repositories\MedicineRepository;
use App\Repositories\PatientRepository;
use Illuminate\Support\Facades\DB;

class MedicalRecordService
{
    protected $medicalRecordRepository;
    protected $medicalRecordDetailRepository;
    protected $userDetailRepository;
    protected $visitRepository;
    protected $medicineRepository;
    protected $patientRepository;

    public function __construct(
        MedicalRecordRepository $medicalRecordRepository,
        MedicalRecordDetailRepository $medicalRecordDetailRepository,
        UserDetailRepository $userDetailRepository,
        VisitRepository $visitRepository,
        MedicineRepository $medicineRepository, // tambahkan ini
        PatientRepository $patientRepository
    ) {
        $this->medicalRecordRepository = $medicalRecordRepository;
        $this->medicalRecordDetailRepository = $medicalRecordDetailRepository;
        $this->userDetailRepository = $userDetailRepository;
        $this->visitRepository = $visitRepository;
        $this->medicineRepository = $medicineRepository; // tambahkan ini
        $this->patientRepository = $patientRepository;
    }

    /**
     * Get all medical records
     * @return array
     */
    public function getAll()
    {
        return $this->medicalRecordRepository->getAll();
    }

    /**
     * Get all medical records with details
     * @return array
     */
    public function getAllMedicalRecords()
    {
        return $this->medicalRecordRepository->getAllMedicalRecords();
    }


    public function getById($id)
    {
        return $this->medicalRecordRepository->getById($id);
    }

    /**
     * Get medical record by ID
     *
     * @param int $id Medical Record ID
     * @return object|null
     */
    public function getMedicalRecordById($id)
    {
        return $this->medicalRecordRepository->query()
            ->join('patients', 'patients.id', '=', 'medical_records.patient_id')
            ->where('medical_records.id', $id)
            ->select(
                'medical_records.*',
                'patients.name as patient_name',
                'patients.nik as patient_nik'
            )
            ->first();
    }

    /**
     * Get medical record detail by patient ID
     *
     * @param int $patientId Patient ID
     * @return object|null
     */
    public function getMedicalRecordDetailByPatientID($patientId)
    {
        return $this->medicalRecordRepository->getMedicalRecordDetailByPatientID($patientId);
    }

    /**
     * Create medical record with detail
     *
     * @param array $data
     * @param int $userId
     * @return object
     */
    public function createMedicalRecordWithDetail($data, $userId)
    {
        $doctor = $this->userDetailRepository->getByUserId($userId);

        if (!$doctor) {
            throw new \Exception('Doctor not found');
        }

        return DB::transaction(function () use ($data, $doctor) {

            $visit = $this->visitRepository->getById($data['visit_id']);
            if (!$visit) {
                throw new \Exception('Visit not found');
            }

            $record = $this->medicalRecordRepository->store([
                'patient_id' => $visit->patient_id,
                'medical_record_number' => $this->generateMedicalRecordNumber(),
                'created_by' => $doctor->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $detailData = [
                'patient_id'        => $visit->patient_id,
                'docter_id'         => $visit->docter_id,
                'visit_id'          => $data['visit_id'],
                'medicine_id'       => $data['medicine_id'],
                'examination_date'  => $data['examination_date'],
                'complaint'         => $data['complaint'],
                'diagnosis'         => $data['diagnosis'],
                'medical_record_id' => $record->id,
                'created_at'        => now(),
                'updated_at'        => now(),
            ];

            $detail = $this->medicalRecordDetailRepository->store($detailData);


            $medicine = $this->medicineRepository->show($data['medicine_id']);
            if ($medicine) {
                if ($medicine->stock <= 0) {
                    throw new \Exception('Obat habis');
                }

                $medicine->stock = max(0, $medicine->stock - 1);
                $medicine->save();
            }

            $response = [
                'medical_record_id' => $record->id,
                'medical_record_number' => $record->medical_record_number,
                'patient_id' => $record->patient_id,
                'created_by' => $doctor->id,
                'detail_id' => $detail->id,
                'visit_id' => $detail->visit_id,
                'medicine_id' => $detail->medicine_id,
                'examination_date' => $detail->examination_date,
                'complaint' => $detail->complaint,
                'diagnosis' => $detail->diagnosis,
                'created_at' => $record->created_at,
            ];

            return $response;
        });
    }

    /**
     * Create medical record number only
     *
     * @param array $data
     * @return array
     */
    public function createMedicalRecordNumberOnly($data)
    {

        return DB::transaction(function () use ($data) {

            $patient = $this->patientRepository->getByID($data['patient_id']);
            if (!$patient) {
                return [null, 'Patient not found'];
            }

            $existNumber = $this->medicalRecordRepository->query()->where('patient_id', $patient->patient_id)->select("medical_record_number");
            if ($existNumber->exists()) {
                return [null, 'Medical record number already exist'];
            }


            $record = $this->medicalRecordRepository->store([
                'patient_id' => $patient->id,
                'medical_record_number' => $this->generateMedicalRecordNumber(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);


            $response = [
                'medical_record_id' => $record->id,
                'medical_record_number' => $record->medical_record_number,
                'patient_id' => $record->patient_id,
            ];

            return $response;
        });
    }

    /**
     * Update medical record number only
     *
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update($id, $data)
    {
        return $this->medicalRecordRepository->update($id, $data);
    }

    public function updateDetail($id, $data)
    {
        return $this->medicalRecordDetailRepository->update($id, $data);
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

    /**
     * Get existing patient by medical record number and birth date
     *
     * @param \Illuminate\Http\Request $request
     * @return object|null
     */
    public function getExistingPatient($request)
    {

       $data =  $this->medicalRecordRepository->query()
        ->join("patients", "patients.id", "=", "medical_records.patient_id")
        ->where('medical_records.medical_record_number', $request['medical_record_number'])
        ->where('patients.birth_date', $request['birth_date'])->select("patients.id", "patients.name", "patients.nik")
        ->first();

        return $data;
    }

    /**
     * Get medical record details by medical record ID
     *
     * @param int $id Medical Record ID
     * @return \Illuminate\Support\Collection
     */
    public function getMedicalRecordDetailsById($id)
    {
        return $this->medicalRecordDetailRepository->query()
            ->join('medical_records', 'medical_records.id', '=', 'medical_records_details.medical_record_id')
            ->join('patients', 'patients.id', '=', 'medical_records_details.patient_id')
            ->leftJoin('users', 'users.id', '=', 'medical_records_details.docter_id')
            ->leftJoin('user_details', 'user_details.user_id', '=', 'users.id')
            ->leftJoin('medicines', 'medicines.id', '=', 'medical_records_details.medicine_id')
            ->where('medical_records_details.medical_record_id', $id)
            ->select(
                'medical_records_details.*',
                'medical_records.medical_record_number',
                'patients.name as patient_name',
                'patients.nik as patient_nik',
                'user_details.name as doctor_name',
                'medicines.name as medicine_name'
            )
            ->get();
    }
}
