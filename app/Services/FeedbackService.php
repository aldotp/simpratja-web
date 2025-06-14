<?php

namespace App\Services;

use App\Repositories\FeedbackRepository;

class FeedbackService
{
    protected $feedbackRepository;

    public function __construct(FeedbackRepository $feedbackRepository)
    {
        $this->feedbackRepository = $feedbackRepository;
    }

    public function store($data)
    {
        return $this->feedbackRepository->store($data);
    }

    public function getAll()
    {
        return $this->feedbackRepository->getFeedbacks();
    }

    public function getById($id)
    {
        return $this->feedbackRepository->getFeedbackByID($id);
    }

    public function countAll()
    {
        return $this->feedbackRepository->countAll();
    }

       public function getByPatientId($patient_id)
    {
        return $this->feedbackRepository->getFeedbackByPatientID($patient_id);
    }
}
