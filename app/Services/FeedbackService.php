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

    /**
     * Store feedback
     * @param array $data
     * @return array
     */
    public function store($data)
    {
        return $this->feedbackRepository->store($data);
    }

    /**
     * Get all feedback
     * @return array
     */
    public function getAll()
    {
        return $this->feedbackRepository->getFeedbacks();
    }

    /**
     * Get feedback by id
     * @param int $id
     * @return array
     */
    public function getById($id)
    {
        return $this->feedbackRepository->getFeedbackByID($id);
    }

    public function countAll()
    {
        return $this->feedbackRepository->countAll();
    }

    /**
     * Get feedback by patient id
     * @param int $patient_id
     * @return array
     */
    public function getByPatientId($patient_id)
    {
        return $this->feedbackRepository->getFeedbackByPatientID($patient_id);
    }
}
