<?php

namespace App\Http\Controllers;

use App\Services\FeedbackService;
use App\Services\ReportService;
use App\Response\Response;

class LeaderController
{
    protected $feedbackService;
    protected $reportService;
    protected $response;

    public function __construct(
        FeedbackService $feedbackService,
        ReportService $reportService,
        Response $response
    ) {
        $this->feedbackService = $feedbackService;
        $this->reportService = $reportService;
        $this->response = $response;
    }

    public function getCounts()
    {
        $feedbackCount = $this->feedbackService->countAll();
        $reportCount = $this->reportService->countAll();

        return $this->response->responseSuccess([
            'feedback_count' => $feedbackCount,
            'report_count' => $reportCount
        ], 'Counts retrieved successfully');
    }
}
