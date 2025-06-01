<?php

namespace App\Http\Controllers\Web;

use App\Services\FeedbackService;
use Illuminate\Support\Facades\Auth;

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
        $role = Auth::user()->role;
        $feedbacks = $this->feedbackService->getAll();
        return view('leader.feedbacks.index', compact('feedbacks'));
    }

    /**
     * Display the specified feedback.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $role = Auth::user()->role;
        $feedback = $this->feedbackService->getById($id);

        return view('leader.feedbacks.show', compact('feedback'));
    }
}
