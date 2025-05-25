<?php

namespace App\Http\Controllers\Web;

use App\Services\MedicineService;
use App\Services\VisitService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class VisitController
{
    protected $visitService;
    protected $medicineService;
    public function __construct(VisitService $visitService, MedicineService $medicineService)
    {
        $this->visitService = $visitService;
        $this->medicineService = $medicineService;
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
            'doctor' => 'doctor.visits.index',
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
        $visits = $this->visitService->getAllVisits([
            'date' => now()->format('Y-m-d'),
            'visit_status' => 'register'
        ]);
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
            'examination_date' => Carbon::parse($visit->examination_date)->translatedFormat('l, d F Y'),
        ]);
    }
}
