<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Response\Response;
use App\Services\MedicalRecordService;
use Illuminate\Support\Facades\Validator;

class MedicalRecordController
{
    protected $medicalRecordService;
    protected $response;

    public function __construct(MedicalRecordService $medicalRecordService, Response $response)
    {
        $this->medicalRecordService = $medicalRecordService;
        $this->response = $response;
    }

    public function getAllMedicalRecord()
    {
        $medicalRecords = $this->medicalRecordService->getAllMedicalRecords();
        return $this->response->responseSuccess($medicalRecords, 'All medical records retrieved successfully');
    }

    public function getMedicalRecordDetailByPatientID($id)
    {
        $medicalRecords = $this->medicalRecordService->getMedicalRecordDetailByPatientID($id);

        if ($medicalRecords->isEmpty()) {
            return $this->response->responseError('Medical records not found', 404);
        }

        return $this->response->responseSuccess($medicalRecords, 'Medical records retrieved successfully');
    }

    public function createMedicalRecord(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'visit_id' => 'required|exists:visits,id',
            'medicine_id' => 'required|exists:medicines,id',
            'examination_date' => 'required|date',
            'complaint' => 'required|string|max:255',
            'diagnosis' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->response->responseError($validator->errors(), 422);
        }

        $payload = $request->attributes->get('user_auth');
        $userId = $payload['id'];

        try {
            $result = $this->medicalRecordService->createMedicalRecordWithDetail($data, $userId);

            if (is_array($result) && isset($result[1]) && $result[1] !== null) {
                return $this->response->responseError($result[1], 422);
            }
        } catch (\Exception $e) {
            return $this->response->responseError('Gagal membuat medical record: ' . $e->getMessage(), 500);
        }

        return $this->response->responseSuccess($result, 'Medical record dan detail berhasil dibuat');
    }

    public function createMedicalRecordNumberOnly($id)
    {
        $data = [
            'visit_id' => $id,
        ];

        $validator = Validator::make($data, [
            'visit_id' => 'required|exists:visits,id',
        ]);

        if ($validator->fails()) {
            return $this->response->responseError($validator->errors(), 422);
        }

        try {
            $result = $this->medicalRecordService->createMedicalRecordNumberOnly($data);

            if (is_array($result) && isset($result[1]) && $result[1] !== null) {
                return $this->response->responseError($result[1], 422);
            }
        } catch (\Exception $e) {
            return $this->response->responseError('Gagal membuat medical record: ' . $e->getMessage(), 500);
        }

        return $this->response->responseSuccess($result, 'Medical record dan detail berhasil dibuat');
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'patient_id' => 'sometimes|required|exists:patients,id',
            'medical_record_number' => 'sometimes|required|string|max:50|unique:medical_records,medical_record_number,' . $id,
            'id' => 'sometimes|required|exists:medical_records_details,id',
            'doctor_id' => 'sometimes|required|exists:docters,id',
            'visit_id' => 'sometimes|required|exists:visits,id',
            'medicine_id' => 'sometimes|required|exists:medicines,id',
            'examination_date' => 'sometimes|required|date',
            'complaint' => 'sometimes|required|string|max:255',
            'diagnosis' => 'sometimes|required|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->response->responseError($validator->errors(), 422);
        }

        $record = $this->medicalRecordService->update($id, $data);
        if (!$record) {
            return $this->response->responseError('Medical record not found', 404);
        }

        $detail = null;
        if (isset($data['medical_record_detail'])) {
            $detailData = $data['medical_record_detail'];
            if (isset($detailData['id'])) {
                $detail = $this->medicalRecordService->updateDetail($detailData['id'], $detailData);
            }
        }

        return $this->response->responseSuccess([
            'medical_record' => $record,
            'medical_record_detail' => $detail
        ], 'Medical record dan detail berhasil diupdate');
    }


    public function getExistingPatient(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'birth_date' => 'required|date',
            'medical_record_number' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->response->responseError($validator->errors(), 422);
        }

        $patients = $this->medicalRecordService->getExistingPatient($request->all());

        if (!$patients) {
            return $this->response->responseError('Pasien tidak ditemukan', 404);
        }

        return $this->response->responseSuccess($patients, 'Data pasien berhasil diambil');
    }
}
