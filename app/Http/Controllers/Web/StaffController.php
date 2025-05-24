<?php

namespace App\Http\Controllers\Web;

use App\Services\PatientService;
use App\Services\VisitService;
use App\Services\FeedbackService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaffController
{
    protected $patientService;
    protected $visitService;
    protected $feedbackService;

    public function __construct(
        PatientService $patientService,
        VisitService $visitService,
        FeedbackService $feedbackService
    ) {
        $this->patientService = $patientService;
        $this->visitService = $visitService;
        $this->feedbackService = $feedbackService;
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
        $feedbackCount = $this->feedbackService->countAll();

        return view('staff.dashboard', compact('patientCount', 'visitCount', 'feedbackCount'));
    }

    
}
