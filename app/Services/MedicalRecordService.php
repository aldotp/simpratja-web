<?php

namespace App\Services;

use App\Repositories\MedicalRecordRepository;
use App\Repositories\MedicalRecordDetailRepository;
use App\Repositories\UserDetailRepository;
use App\Repositories\VisitRepository;
use App\Repositories\MedicineRepository;
use Illuminate\Support\Facades\DB;

class MedicalRecordService
{
    protected $medicalRecordRepository;
    protected $medicalRecordDetailRepository;
    protected $userDetailRepository;
    protected $visitRepository;
    protected $medicineRepository;

    public function __construct(
        MedicalRecordRepository $medicalRecordRepository,
        MedicalRecordDetailRepository $medicalRecordDetailRepository,
        UserDetailRepository $userDetailRepository,
        VisitRepository $visitRepository,
        MedicineRepository $medicineRepository // tambahkan ini
    ) {
        $this->medicalRecordRepository = $medicalRecordRepository;
        $this->medicalRecordDetailRepository = $medicalRecordDetailRepository;
        $this->userDetailRepository = $userDetailRepository;
        $this->visitRepository = $visitRepository;
        $this->medicineRepository = $medicineRepository; // tambahkan ini
    }

    public function getAll()
    {
        return $this->medicalRecordRepository->getAll();
    }

    public function getAllMedicalRecords()
    {
        return $this->medicalRecordRepository->getAllMedicalRecords();
    }

    public function getById($id)
    {
        return $this->medicalRecordRepository->getById($id);
    }

    public function getMedicalRecordDetailByPatientID($patientId)
    {
        return $this->medicalRecordRepository->getMedicalRecordDetailByPatientID($patientId);
    }

    public function createMedicalRecordWithDetail($data, $userId)
    {
        $doctor = $this->userDetailRepository->getByUserId($userId);

        if (!$doctor) {
            return [null, 'Doctor not found'];
        }

        return DB::transaction(function () use ($data, $doctor) {

            $visit = $this->visitRepository->getById($data['visit_id']);
            if (!$visit) {
                return [null, 'Visit not found'];
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

            // Kurangi stok obat
            $medicine = $this->medicineRepository->getByID($data['medicine_id']);
            if ($medicine) {
                if ($medicine->stock <= 0) {
                    return [null, 'Obat habis'];
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

    public function update($id, $data)
    {
        return $this->medicalRecordRepository->update($id, $data);
    }

    public function updateDetail($id, $data)
    {
        return $this->medicalRecordDetailRepository->update($id, $data);
    }



    public function generateMedicalRecordNumber()
    {
        $date = date('Ymd');
        $random = mt_rand(100, 999);
        return "MRN{$date}{$random}";
    }
}
