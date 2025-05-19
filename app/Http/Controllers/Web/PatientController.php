<?php

namespace App\Http\Controllers\Web;

use App\Repositories\PatientRepository;
use App\Repositories\VisitRepository;
use App\Services\PatientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientController
{
    protected $patientRepository;
    protected $visitRepository;
    protected $response;
    protected $patientService;

    public function __construct(PatientRepository $patientRepository, VisitRepository $visitRepository, PatientService $patientService)
    {
        $this->patientRepository = $patientRepository;
        $this->visitRepository = $visitRepository;
        $this->patientService = $patientService;
    }

    public function portal()
    {
        return view('portal');
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
            return redirect()->back()->withErrors($validator)->withInput();
        }

        list($response, $error) = $this->patientService->registerPatientWithVisit($data);

        if ($error) {
            return $this->response->responseError($error, 422);
        }

        return $this->response->responseSuccess($response, 'Pendaftaran pasien & visit berhasil');
    }
}
