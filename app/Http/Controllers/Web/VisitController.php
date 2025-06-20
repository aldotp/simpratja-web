<?php

namespace App\Http\Controllers\Web;

use App\Response\Response;
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
    protected $response;
    public function __construct(Response $response, VisitService $visitService, MedicineService $medicineService, StaffService $staffService, DocterService $docterService)
    {
        $this->response = $response;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $role = Auth::user()->role;
        $filters = [];

        // Apply date range filter if provided
        if ($request->has('visit_date_start') && $request->filled('visit_date_start')) {
            $filters['start_date'] = $request->visit_date_start;
        } else {
            $filters['date'] = now()->format('Y-m-d');
        }

        if ($request->has('visit_date_end') && $request->filled('visit_date_end')) {
            $filters['end_date'] = $request->visit_date_end;
        }

        if ($role === 'docter') {
            $doctorId = Auth::id();
            $filters['doctor_id'] = $doctorId;
            $filters['visit_status'] = ['queue', 'check'];
        }

        $visits = $this->visitService->getAllVisits($filters);
        $medicines = $this->medicineService->getAllWithStock();

        return $this->viewByRole($role, compact('visits', 'medicines'));
    }

    /**
     * Display a listing of the visits.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function history(Request $request) {
        $filters = [];

        // Apply date range filter if provided
        if ($request->has('visit_date_start') && $request->filled('visit_date_start')) {
            $filters['start_date'] = $request->visit_date_start;
        }

        if ($request->has('visit_date_end') && $request->filled('visit_date_end')) {
            $filters['end_date'] = $request->visit_date_end;
        }

        $visits = $this->visitService->getAllVisits($filters);
        return view('staff.histories.index', compact('visits'));
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
            'complaint' => $visit->complaint ?? '',
            'diagnosis' => $visit->diagnosis?? '',
            'medicine' => $visit->medicine_name?? '',
        ]);
    }

    public function validateRegisterPatient($id){
        $data = $this->staffService->ValidateRegisterPatient($id);
        if (!$data) {
            return redirect()->back()->with('error', 'Error when validating register patient');
        }


        return redirect()->route('staff.visits.index')->with('success', 'Berhasil validasi pasien');
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

    public function callPatient($id) {
        $role = Auth::user()->role;

        if (is_null($id) || !is_numeric($id)) {
            return redirect()->back()->with('error', 'Pasien tidak ditemukan');
        }

        $this->visitService->callPatient($id);

        if ($role === 'docter') {
            return redirect()->route('doctor.visits.index')->with('success', 'Panggil pasien berhasil');
        }
        return redirect()->route('staff.visits.index')->with('success', 'Panggil pasien berhasil');
    }
}
