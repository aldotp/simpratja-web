<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Response\Response;
use App\Repositories\PatientRepository;
use App\Repositories\VisitRepository;
use App\Services\PatientService;
use Illuminate\Support\Facades\Validator;

class PatientController
{
    protected $patientRepository;
    protected $visitRepository;
    protected $response;
    protected $patientService;

    public function __construct(PatientRepository $patientRepository, VisitRepository $visitRepository, Response $response, PatientService $patientService)
    {
        $this->patientRepository = $patientRepository;
        $this->visitRepository = $visitRepository;
        $this->response = $response;
        $this->patientService = $patientService;
    }

    public function register(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'nik' => 'required',
            'name' => 'required|string|max:50',
            'birth_date' => 'required|date',
            'gender' => 'required|integer|max:1',
            'blood_type' => 'required|string|max:5',
            'religion' => 'required|string|max:50',
            'status' => 'required|integer|max:1',
            'address' => 'required|string|max:50',
            'phone_number' => 'required|string|max:20',
            'docter_id' =>'required|integer|max:10',
            'examination_date' => 'required|date',
            'insurance' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return $this->response->responseError($validator->errors(), 422);
        }

        list($response, $error) = $this->patientService->registerPatientWithVisit($data);

        if ($error) {
            return $this->response->responseError($error, 422);
        }

        return $this->response->responseSuccess($response, 'Pendaftaran pasien & visit berhasil');
    }

    public function showRegistration($id)
    {
        $patient = $this->patientService->getRegistration($id);

        if (!$patient) {
            return $this->response->responseError('Data pasien tidak ditemukan', 404);
        }

        return $this->response->responseSuccess($patient, 'Data pendaftaran ditemukan');
    }

    public function showRegistrationByRegistrationIDandNIK(Request $request)
    {
        $data = [
            'nik' => $request->query('nik'),
            'registration_number' => $request->query('registration_number'),
        ];

        $validator = Validator::make($data, [
            'nik' => 'required',
            'registration_number'=> 'required',
        ]);

        if ($validator->fails()) {
            return $this->response->responseError($validator->errors(), 422);
        }

        $patient = $this->patientService->getRegisByRegistrationIDandNIK($data);

        if (!$patient) {
            return $this->response->responseError('Data pasien tidak ditemukan', 404);
        }

        return $this->response->responseSuccess($patient, 'Data pendaftaran ditemukan');
    }

    public function getAllRegistration(Request $request)
    {
        $patients = $this->patientService->getAllRegistration($request->all());
        return $this->response->responseSuccess($patients, 'Data pasien berhasil diambil');
    }

    public function index()
    {
        $patients = $this->patientService->getAll();
        return $this->response->responseSuccess($patients, 'Data pasien berhasil diambil');
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'nik' => 'required|unique:patients,nik',
            'name' => 'required|string|max:50',
            'birth_date' => 'required|date',
            'gender' => 'required|integer|max:1',
            'blood_type' => 'required|string|max:5',
            'religion' => 'required|string|max:50',
            'status' => 'required|integer|max:1',
            'address' => 'required|string|max:50',
            'phone_number' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return $this->response->responseError($validator->errors(), 422);
        }

        $patient = $this->patientService->update($id, $data);
        if (!$patient) {
            return $this->response->responseError('Pasien tidak ditemukan', 404);
        }
        return $this->response->responseSuccess($patient, 'Data pasien berhasil diupdate');
    }

    public function destroy($id)
    {
        $patient = $this->patientService->delete($id);
        if (!$patient) {
            return $this->response->responseError('Pasien tidak ditemukan', 404);
        }
        return $this->response->responseSuccess($patient, 'Data pasien berhasil dihapus');
    }
}
