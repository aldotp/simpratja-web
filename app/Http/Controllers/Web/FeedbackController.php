<?php

namespace App\Http\Controllers\Web;

use App\Services\FeedbackService;
use Illuminate\Http\Request;

class FeedbackController
{
    protected $feedbackService;

    public function __construct(FeedbackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
    }


    /**
     * Display a listing of the feedbacks.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $feedbacks = $this->feedbackService->getAll();
        return view('leader.feedbacks.index', compact('feedbacks'));
    }
}
