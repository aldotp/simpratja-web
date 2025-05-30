<?php

namespace App\Http\Controllers\Web;

use App\Services\FeedbackService;
use App\Services\ReportService;
use Illuminate\Http\Request;

class LeaderController
{
    protected $feedbackService;
    protected $reportService;

    public function __construct(
        FeedbackService $feedbackService,
        ReportService $reportService,
    ) {
        $this->feedbackService = $feedbackService;
        $this->reportService = $reportService;
    }

    public function dashboard()
    {
        $feedbackCount = $this->feedbackService->countAll();
        $reportCount = $this->reportService->countAll();

        return view('leader.dashboard', compact('feedbackCount', 'reportCount'));
    }
}
