<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Services\MedicalRecordService;
use App\Services\VisitService;
use App\Services\MedicineService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController
{
    protected $medicalRecordService;
    protected $visitService;
    protected $medicineService;

    /**
     * Create a new controller instance.
     *
     * @param MedicalRecordService $medicalRecordService
     * @param VisitService $visitService
     * @param MedicineService $medicineService
     */
    public function __construct(
        MedicalRecordService $medicalRecordService,
        VisitService $visitService,
        MedicineService $medicineService
    ) {
        $this->medicalRecordService = $medicalRecordService;
        $this->visitService = $visitService;
        $this->medicineService = $medicineService;
    }

    /**
     * Display a listing of the visits.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $visits = $this->visitService->getAllVisits(['visit_status' => 1]);
        $medicines = $this->medicineService->getAll();
        return view('doctor.visits.index', compact('visits', 'medicines'));
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
            'doctor_name' => $visit->docter->name ?? 'Tidak ada dokter',
            'patient_name' => $visit->patient->name ?? 'Tidak ada pasien',
            'examination_date' => $visit->examination_date,
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
            $result = $this->medicalRecordService->createMedicalRecordWithDetail($request->all(), $userId);

            if (is_array($result) && isset($result[1]) && $result[1] !== null) {
                return redirect()->back()->with('error', $result[1]);
            }

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
