<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Response\Response;
use App\Services\FeedbackService;
use Illuminate\Support\Facades\Validator;

class FeedbackController
{
    protected $feedbackService;
    protected $response;

    public function __construct(FeedbackService $feedbackService, Response $response)
    {
        $this->feedbackService = $feedbackService;
        $this->response = $response;
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'patient_id' => 'required|exists:patients,id',
            'feedback_content' => 'required|string',
            'feedback_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return $this->response->responseError($validator->errors(), 422);
        }

        $feedback = $this->feedbackService->store($data);

        return $this->response->responseSuccess($feedback, 'Feedback submitted successfully');
    }

    public function index()
    {
        $feedbacks = $this->feedbackService->getAll();
        return $this->response->responseSuccess($feedbacks, 'All feedbacks retrieved');
    }

    public function show($id)
    {
        $feedback = $this->feedbackService->getById($id);
        if (!$feedback) {
            return $this->response->responseError('Feedback not found', 404);
        }
        return $this->response->responseSuccess($feedback, 'Feedback found');
    }
}
