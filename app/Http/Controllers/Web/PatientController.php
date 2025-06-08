<?php

namespace App\Http\Controllers\Web;

use App\Repositories\PatientRepository;
use App\Repositories\VisitRepository;
use App\Response\Response;
use App\Services\DocterService;
use App\Services\MedicalRecordService;
use App\Services\PatientService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientController
{
    protected $patientRepository;
    protected $visitRepository;
    protected $patientService;
    protected $medicalRecordService;
    protected $doctorService;
    protected $response;

    public function __construct(PatientRepository $patientRepository, VisitRepository $visitRepository, PatientService $patientService, MedicalRecordService $medicalRecordService, DocterService $doctorService, Response $response)
    {
        $this->patientRepository = $patientRepository;
        $this->visitRepository = $visitRepository;
        $this->patientService = $patientService;
        $this->medicalRecordService = $medicalRecordService;
        $this->doctorService = $doctorService;
        $this->response = $response;
    }

    public function portal()
    {
        // Ambil daftar dokter untuk dropdown
        $doctors = $this->doctorService->getAll();
        return view('portal', compact('doctors'));
    }

    /**
     * Register a new patient.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $this->patientService->registerPatientWithVisit($data);
            return redirect()->route('portal')->with('success', 'Pasien berhasil didaftarkan');
        } catch (\Exception $error) {
            return redirect()->back()->with('error', 'Gagal menambahkan data')->withErrors($error)->withInput();
        }
    }

    /**
     * Get existing patient by birth date and medical record number.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Register an existing patient's visit.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerExistingPatientVisit(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'patient_id' => 'required|exists:patients,id',
            'visit_date' => 'required|date',
            'docter_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $this->patientService->registerExistingPatientVisit($data);
            return redirect()->route('portal')->with('success', 'Kunjungan pasien berhasil didaftarkan');
        } catch (\Exception $error) {
            return redirect()->back()->withErrors($error)->withInput();
        }
    }


    /**
     * Show registration details by registration ID and NIK.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * Export registration queue to PDF.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportQueueToPDF(Request $request)
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


        $data = $this->patientService->getRegisByRegistrationIDandNIK($data);

        if (!$data) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $viewData = [
            'regNumber'    => $data['visit_registration_number'] ?? '',
            'patientName'  => $data['patient_name'] ?? '',
            'docterName'     => $data['docter_name'] ?? '',
            'address'      => $data['patient_address'] ?? '',
            'registerDate' => Carbon::parse($data['visit_examination_date'])->translatedFormat('l, d F Y') ?? '',
            'examDate'     => Carbon::parse($data['visit_examination_date'])->translatedFormat('l, d F Y') ?? '',
            'queueNumber'  => $data['visit_queue_number'] ?? '',
        ];

        $pdf = Pdf::loadView('receipt', $viewData);

        return $pdf->download('receipt.pdf');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index() {
        $patients = $this->patientService->getAll();
        return view('staff.patients.index', compact('patients'));
    }

    /**
     * Show the form for editing the specified patient.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $patient = $this->patientService->getByID($id);
        if (!$patient) {
            return redirect()->route('staff.patient.index')->with('error', 'Pasien tidak ditemukan');
        }

        return view('staff.patients.edit', compact('patient'));
    }

    /**
     * Update the specified patient in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required',
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
            return redirect()->back()->withErrors($request->all())->withInput();
        }

        $patient = $this->patientService->update($id, $request->all());

        if (!$patient) {
            return redirect()->back()->with('error', 'Gagal mengupdate data pasien');
        }

        return redirect()->route('staff.patients.index', $id)->with('success', 'Data pasien berhasil diupdate');
    }

    /**
     * Remove the specified patient from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $result = $this->patientService->deletePatient($id);
        if (!$result) {
            return redirect()->back()->with('error', 'Gagal menghapus data pasien');
        }

        return redirect()->route('staff.patients.index')->with('success', 'Data pasien berhasil dihapus');
    }

    public function generateMRN($id)
    {
        $data = [
            'patient_id' => $id,
        ];

        $validator = Validator::make($data, [
            'patient_id' => 'required|exists:patients,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        try {
            $result = $this->medicalRecordService->createMedicalRecordNumberOnly($data);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat medical record: ' . $e->getMessage());
        }

        return redirect()->route('staff.patients.index')->with('success', 'Medical record dan detail berhasil dibuat');
    }
}
