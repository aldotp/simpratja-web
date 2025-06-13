<?php

namespace App\Services;

use App\Repositories\MedicineRepository;
use App\Repositories\MedicalRecordDetailRepository;

class MedicineService
{
    protected $medicineRepository;
    protected $medicalRecordDetailRepository;

    public function __construct(MedicineRepository $medicineRepository, MedicalRecordDetailRepository $medicalRecordDetailRepository)
    {
        $this->medicineRepository = $medicineRepository;
        $this->medicalRecordDetailRepository = $medicalRecordDetailRepository;
    }

    public function getAll()
    {
        return $this->medicineRepository->getAll();
    }

    public function show($id)
    {
        return $this->medicineRepository->show($id);
    }

    public function store($data)
    {
        return $this->medicineRepository->store($data);
    }

    public function update($id, $data)
    {
        return $this->medicineRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->medicineRepository->delete($id);
    }

    public function deleteMedicines($id)
    {
        $patient = $this->medicineRepository->getByID($id);
        if (!$patient) {
            return 'data not found';
        }


        $feedbacks = $this->medicalRecordDetailRepository->queryWhere(['medicine_id' => $id]);

        if ($feedbacks->count() > 0) {
            foreach ($feedbacks as $feedback) {
                $this->medicalRecordDetailRepository->delete($feedback->id);
            }
        }

        $patient = $this->medicineRepository->delete($id);

        return $patient;
    }

    public function getAllWithStock()
    {
        return $this->medicineRepository->getAllWithStock();
    }
}
