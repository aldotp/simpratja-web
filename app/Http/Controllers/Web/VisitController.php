<?php

namespace App\Http\Controllers\Web;

use App\Services\DocterService;
use App\Services\MedicineService;
use App\Services\StaffService;
use App\Services\VisitService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class VisitController
{
    protected $visitService;
    protected $medicineService;
    protected $staffService;
    protected $docterService;
    public function __construct(VisitService $visitService, MedicineService $medicineService, StaffService $staffService, DocterService $docterService)
    {
        $this->visitService = $visitService;
        $this->medicineService = $medicineService;
        $this->staffService = $staffService;
        $this->docterService = $docterService;
    }

    /**
     * Get the view name based on the user role and return it with data.
     *
     * @param string $role
     * @param array $data
     * @return \Illuminate\View\View
     */
    private function viewByRole($role, $data = [])
    {
        // Get the view name based on the role
        $view = match ($role) {
            'docter' => 'doctor.visits.index',
            'staff' => 'staff.visits.index',
            default => 'staff.visits.index',
        };

        // Return the view with the data (just like the view() function)
        return view($view, $data);
    }
    /**
     * Display a listing of the visits.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $role = Auth::user()->role;
        if ($role === 'docter') {
            $doctorId = Auth::id();
            $visits = $this->visitService->getAllVisits([
                'date' => now()->format('Y-m-d'),
                'doctor_id' => $doctorId,
                'visit_status' => ['queue', 'check'],
            ]);
        } else {
            $visits = $this->visitService->getAllVisits([
                'date' => now()->format('Y-m-d'),
            ]);
        }
        $medicines = $this->medicineService->getAll();

        return $this->viewByRole($role, compact('visits', 'medicines'));
    }

    /**
     * Display a listing of the visits.
     *
     * @return \Illuminate\View\View
     */
    public function history() {
        $visits = $this->visitService->getAllVisits();
        return view('staff.history.index', compact('visits'));
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
            'examination_date' => Carbon::parse($visit->examination_date)->translatedFormat('l, d F Y') ?? now()->format('l, d F Y'),
            'complaint' => $visit->complaint ?? 'Tidak ada keluhan',
            'diagnosis' => $visit->diagnosis?? 'Tidak ada diagnosis',
            'medicine' => $visit->medicine_name?? 'Tidak ada obat',
        ]);
    }

    public function validateRegisterPatient($id){
        $data = $this->staffService->ValidateRegisterPatient($id);
        if (!$data) {
            return redirect()->back()->with('error', 'Error when validating register patient');
        }


        return redirect()->route('staff.visits.index')->with('success', 'validate patient success');
    }

    public function checkUpPatient($id, Request $request) {
        $data = $request->all();
        $validator = Validator::make($data, [
            'medicine_id' => 'required',
            'diagnosis' => 'required|string',
            'complaint' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $this->docterService->checkUpPatient($id,$data);
        return redirect()->route('doctor.visits.index')->with('success', 'Check up patient success');
    }
}
