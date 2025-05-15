<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Response\Response;
use App\Services\VisitService;
use Illuminate\Support\Facades\Validator;

class VisitController
{
    protected $visitService;
    protected $response;

    public function __construct(VisitService $visitService, Response $response)
    {
        $this->visitService = $visitService;
        $this->response = $response;
    }

    public function getQueueNumber($id)
    {
        $queueNumber = $this->visitService->getQueueNumber($id);

        if ($queueNumber === null) {
            return $this->response->responseError('Visit data not found', 404);
        }

        return $this->response->responseSuccess(['queue_number' => $queueNumber], 'Queue number retrieved successfully');
    }

    public function getAllVisits(Request $request)
    {
        $filters = $request->all();
        $visits = $this->visitService->getAllVisits($filters);

        return $this->response->responseSuccess($visits, 'All visits retrieved successfully');
    }

    public function getVisitByID($id)
    {
        $visit = $this->visitService->getVisitById($id);
        if (!$visit) {
            return $this->response->responseError('Visit not found', 404);
        }
        return $this->response->responseSuccess($visit, 'Visit found');
    }

    public function validateVisits($id){
        $visits = $this->visitService->validateVisits($id);
        if(!$visits){
            return $this->response->responseError('Visit not found', 404);
        }
        return $this->response->responseSuccess($visits, 'Validate Success');
    }

    public function registerExistingPatientVisit(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'patient_id' => 'required|exists:patients,id',
            'visit_date' => 'required|date',
            'complaint' => 'required|string',
            'docter_id' => 'required',
            'insurance' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->response->responseError($validator->errors(), 422);
        }

        $visit = $this->visitService->registerExistingPatientVisit($data);
        return $this->response->responseSuccess($visit, 'Visit registered successfully');
    }
}