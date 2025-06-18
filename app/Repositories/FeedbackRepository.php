<?php

namespace App\Repositories;

use App\Models\Feedback;

class FeedbackRepository
{
    /**
     * Store feedback data.
     * @param {Object} data - The feedback data to store.
     * @returns {Feedback} The created feedback instance.
     */
    public function store($data)
    {
        return Feedback::create($data);
    }

    /**
     * Retrieve all feedbacks.
     * @returns {Array<Feedback>} List of all feedbacks.
     */
    public function getAll()
    {
        return Feedback::all();
    }

    /**
     * Retrieve feedbacks with patient information.
     * @returns {Array<Object>} List of feedbacks with patient details.
     */
    public function getFeedbacks()
    {
        $query = Feedback::query()
            ->select("feedbacks.id", "patients.name", "feedbacks.feedback_content", "feedbacks.rating", "feedbacks.created_at")
            ->join('patients', 'feedbacks.patient_id', '=', 'patients.id');

        return $query->get();
    }


    /**
     * Retrieve feedback by ID.
     * @param {number} id - The ID of the feedback.
     * @returns {Feedback|null} The feedback instance or null if not found.
     */
    public function getFeedbackByID($id)
    {
        $query = Feedback::query()
        ->select("feedbacks.id", "patients.name", "feedbacks.feedback_content", "feedbacks.rating", "feedbacks.created_at")
        ->join('patients', 'feedbacks.patient_id', '=', 'patients.id')
        ->where('feedbacks.id', $id);

        $data = $query->first();
        if ($data) {
            return $data;
        } else {
            return null;
        }
    }

    /**
     * Update feedback data.
     * @param {number} id - The ID of the feedback to update.
     * @param {Object} data - The updated feedback data.
     * @returns {Feedback|null} The updated feedback instance or null if not found.
     */
    public function getById($id)
    {
        return Feedback::find($id);
    }

    public function queryWhere($conditions)
    {
        $query = Feedback::query();

        foreach ($conditions as $field => $value) {
            $query->where($field, $value);
        }

        return $query->get();
    }

    /**
     * Count all feedbacks.
     * @returns {number} The total count of feedbacks.
     */
    public function countAll()
    {
        return Feedback::count();
    }

    /**
     * Delete feedback by ID.
     * @param {number} id - The ID of the feedback to delete.
     * @returns {Feedback|null} The deleted feedback instance or null if not found.
     */
    public function delete($id)
    {
        $feedback = Feedback::find($id);
        $feedback->delete();
        return $feedback;
    }

    /**
     * Retrieve feedback by patient ID.
     * @param {number} patient_id - The ID of the patient.
     * @returns {Feedback|null} The feedback instance or null if not found.
     */
    public function getFeedbackByPatientID($patient_id)
    {
        $query = Feedback::query()
        ->select("feedbacks.id")
        ->where('feedbacks.patient_id', $patient_id);

        $data = $query->first();
        if ($data) {
            return $data;
        } else {
            return null;
        }
    }
}
