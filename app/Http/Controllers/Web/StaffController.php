<?php

namespace App\Http\Controllers\Web;

use App\Services\PatientService;
use App\Services\VisitService;
use App\Services\FeedbackService;

class StaffController
{
    protected $patientService;
    protected $visitService;

    public function __construct(
        PatientService $patientService,
        VisitService $visitService,
    ) {
        $this->patientService = $patientService;
        $this->visitService = $visitService;
    }

    /**
     * Display the staff dashboard with counts.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $patientCount = $this->patientService->countAll();
        $visitCount = $this->visitService->countAll();

        return view('staff.dashboard', compact('patientCount', 'visitCount'));
    }


}
