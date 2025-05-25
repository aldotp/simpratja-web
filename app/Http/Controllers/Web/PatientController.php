<?php

namespace App\Http\Controllers\Web;

use App\Repositories\PatientRepository;
use App\Repositories\VisitRepository;
use App\Services\MedicalRecordService;
use App\Services\PatientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientController
{
    protected $patientRepository;
    protected $visitRepository;
    protected $patientService;
    protected $medicalRecordService;

    public function __construct(PatientRepository $patientRepository, VisitRepository $visitRepository, PatientService $patientService, MedicalRecordService $medicalRecordService)
    {
        $this->patientRepository = $patientRepository;
        $this->visitRepository = $visitRepository;
        $this->patientService = $patientService;
        $this->medicalRecordService = $medicalRecordService;
    }

    public function portal()
    {
        return view('portal');
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
            'insurance' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        list($response, $error) = $this->patientService->registerPatientWithVisit($data);

        if ($error) {
            return redirect()->back()->withErrors($error)->withInput();
        }

        return redirect()->route('portal')->with('success', 'Pasien berhasil didaftarkan');
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

        $visit = $this->patientService->registerExistingPatientVisit($data);

        if (is_array($visit) && isset($visit[1]) && $visit[1] !== null) {
            return redirect()->back()->withErrors($visit[1])->withInput();
        }
        if (is_array($visit) && isset($visit[2]) && $visit[2] !== null) {
            return redirect()->back()->withErrors($visit[2])->withInput();
        }

        return redirect()->route('portal')->with('success', 'Kunjungan pasien berhasil didaftarkan');
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
            'visit_id' => $id,
        ];

        $validator = Validator::make($data, [
            'visit_id' => 'required|exists:visits,id',
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
