<?php

namespace App\Http\Controllers\Web;

use App\Response\Response;
use Illuminate\Http\Request;
use App\Services\MedicalRecordService;
use App\Services\VisitService;
use App\Services\MedicineService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController
{
    protected $medicalRecordService;
    protected $visitService;
    protected $medicineService;
    protected $response;

    /**
     * Create a new controller instance.
     *
     * @param MedicalRecordService $medicalRecordService
     * @param VisitService $visitService
     * @param MedicineService $medicineService
     * @param Response $response
     */
    public function __construct(
        MedicalRecordService $medicalRecordService,
        VisitService $visitService,
        MedicineService $medicineService,
        Response $response
    ) {
        $this->medicalRecordService = $medicalRecordService;
        $this->visitService = $visitService;
        $this->medicineService = $medicineService;
        $this->response = $response;
    }

    public function index()
    {
        $medicalRecords = $this->medicalRecordService->getAllMedicalRecords();
        return view('staff.medical-records.index', compact('medicalRecords'));
    }

    public function show($id)
    {
        $medicalRecords = $this->medicalRecordService->getMedicalRecordDetailByPatientID($id);

        if ($medicalRecords->isEmpty()) {
            return abort(404);
        }

        return view('staff.medical-records.detail', compact('medicalRecords'));
    }

    /**
     * Get medical record details for AJAX request.
     *
     * @param int $id Medical Record ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDetails($id)
    {
        $medicalRecords = $this->medicalRecordService->getMedicalRecordDetailByPatientID($id);

        if ($medicalRecords->isEmpty()) {
            return $this->response->responseError('Medical records not found', 404);
        }

        // Format examination_date to 'l, d F Y' format
        $formattedRecords = $medicalRecords->map(function($record) {
            if (isset($record->examination_date)) {
                $record->examination_date = \Carbon\Carbon::parse($record->examination_date)->translatedFormat('l, d F Y');
            }
            return $record;
        });

        return $this->response->responseSuccess([
            'details'=> $formattedRecords,
        ], 'Medical records retrieved successfully');
    }

    /**
     * Get visit details for medical record form.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVisitDetails($id)
    {
        $visit = $this->visitService->getVisitById($id);

        if (!$visit) {
            return response()->json(['error' => 'Kunjungan tidak ditemukan'], 404);
        }

        return response()->json([
            'doctor_name' => $visit->doctor_name ?? 'Tidak ada dokter',
            'patient_name' => $visit->patient_name ?? 'Tidak ada pasien',
            'examination_date' => Carbon::parse($visit->examination_date)->translatedFormat('l, d F Y'),
        ]);
    }

    /**
     * Store a newly created medical record in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'visit_id' => 'required|exists:visits,id',
            'medicine_id' => 'required|exists:medicines,id',
            'examination_date' => 'required|date',
            'complaint' => 'required|string|max:255',
            'diagnosis' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userId = Auth::id();

        try {
            $this->medicalRecordService->createMedicalRecordWithDetail($request->all(), $userId);

            // Update visit status to completed (2)
            $this->visitService->validateVisits($request->visit_id);

            return redirect()->route('doctor.visits.index')
                ->with('success', 'Rekam medis berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menyimpan rekam medis: ' . $e->getMessage())
                ->withInput();
        }
    }
}
