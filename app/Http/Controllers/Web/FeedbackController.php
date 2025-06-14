<?php

namespace App\Http\Controllers\Web;

use App\Response\Response;
use App\Services\FeedbackService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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

    /**
     * Store a newly created feedback in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required',
            'feedback_content' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        if ($validator->fails()) {
            session(['validation-feedback']);
            return redirect()->back()
                ->with('error', 'Gagal mengirim feedback. Silakan coba lagi.')
                ->withErrors($validator)
                ->withInput();
        }

        $this->feedbackService->store($request->all());

        return redirect()->back()->with('success', 'Terima kasih! Feedback Anda telah berhasil dikirim.');
    }

    public function checkExistFeedbackByPatientId($patient_id){
        $response =  $this->feedbackService->getByPatientId($patient_id);

        return $this->response->responseSuccess($response);
    }
}
