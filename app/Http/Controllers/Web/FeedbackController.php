<?php

namespace App\Http\Controllers\Web;

use App\Services\FeedbackService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController
{
    protected $feedbackService;

    public function __construct(FeedbackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
    }

        /**
     * Get the view name based on the user role and return it with data.
     *
     * @param string $role
     * @param array $data
     * @return \Illuminate\View\View
     */
    private function viewByRole($role, $data = [])
    {
        // Get the view name based on the role
        $view = match ($role) {
            'leader' => 'leader.feedbacks.index',
            'staff' => 'staff.feedbacks.index',
            default => 'feedbacks.index',
        };

        // Return the view with the data (just like the view() function)
        return view($view, $data);
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
        return $this->viewByRole($role, compact('feedbacks'));
    }
}
