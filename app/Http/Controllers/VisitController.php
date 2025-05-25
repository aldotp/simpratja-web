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

    public function checkStatusVisit(Request $request)
    {
        $data = [
            'patient_id' => $request->query('patient_id'),
            'examination_date' => $request->query('examination_date'),
        ];

        $validator = Validator::make($data, [
            'patient_id' => 'required',
            'examination_date' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->response->responseError($validator->errors(), 422);
        }

        $visit = $this->visitService->checkStatusVisit($data);


        $isDone = false;

        if ($visit !== null) {
            $isDone = $visit->visit_status === 'done';
        }


        return $this->response->responseSuccess(["is_done" => $isDone], 'Visit status checked successfully');
    }

    public function callPatient($id) {

        if (is_null($id) || !is_numeric($id)) {
            return $this->response->responseError('Patient ID is required', 400);
        }

        $result = $this->visitService->callPatient($id);
        return $this->response->responseSuccess($result, 'Call patient success');
    }

}