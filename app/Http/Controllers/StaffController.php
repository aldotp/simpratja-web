<?php

namespace App\Http\Controllers;

use App\Services\PatientService;
use App\Services\VisitService;
use App\Services\FeedbackService;
use App\Response\Response;

class StaffController
{
    protected $patientService;
    protected $visitService;
    protected $feedbackService;
    protected $response;

    public function __construct(
        PatientService $patientService,
        VisitService $visitService,
        FeedbackService $feedbackService,
        Response $response
    ) {
        $this->patientService = $patientService;
        $this->visitService = $visitService;
        $this->feedbackService = $feedbackService;
        $this->response = $response;
    }

    public function getCounts()
    {
        $patientCount = $this->patientService->countAll();
        $visitCount = $this->visitService->countAll();
        $feedbackCount = $this->feedbackService->countAll();

        return $this->response->responseSuccess([
            'patient_count' => $patientCount,
            'visit_count' => $visitCount,
            'feedback_count' => $feedbackCount
        ], 'Counts retrieved successfully');
    }
}
