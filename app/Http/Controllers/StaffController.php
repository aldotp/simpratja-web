<?php

namespace App\Http\Controllers;

use App\Services\PatientService;
use App\Services\VisitService;
use App\Services\FeedbackService;
use App\Services\StaffService;
use App\Response\Response;
use Illuminate\Support\Facades\Validator;

class StaffController
{
    protected $patientService;
    protected $visitService;
    protected $feedbackService;
    protected $response;
    protected $staffService;

    public function __construct(
        PatientService $patientService,
        VisitService $visitService,
        FeedbackService $feedbackService,
        Response $response,
        StaffService $staffService
    ) {
        $this->patientService = $patientService;
        $this->visitService = $visitService;
        $this->feedbackService = $feedbackService;
        $this->response = $response;
        $this->staffService = $staffService;
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


    public function validateRegisterPatient($id){


        $data = $this->staffService->ValidateRegisterPatient($id);
        if (!$data) {
            return $this->response->responseError("error when validate register patient", 404);
        }


        return $this->response->responseSuccess($data, 'validate patient success');
    }
}