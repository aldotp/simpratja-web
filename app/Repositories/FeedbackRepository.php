<?php

namespace App\Repositories;

use App\Models\Feedback;

class FeedbackRepository
{
    public function store($data)
    {
        return Feedback::create($data);
    }

    public function getAll()
    {
        return Feedback::all();
    }

    public function getFeedbacks()
    {
        $query = Feedback::query()
            ->select("feedbacks.id", "patients.name", "feedbacks.feedback_content", "feedbacks.feedback_date")
            ->join('patients', 'feedbacks.patient_id', '=', 'patients.id');

        return $query->get();
    }

    public function getFeedbackByID($id)
    {
        $query = Feedback::query()
        ->select("feedbacks.id", "patients.name", "feedbacks.feedback_content", "feedbacks.feedback_date")
        ->join('patients', 'feedbacks.patient_id', '=', 'patients.id')
        ->where('feedbacks.id', $id);

        $data = $query->first();
        if ($data) {
            return $data;
        } else {
            return null;
        }
    }

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

    public function countAll()
    {
        return Feedback::count();
    }

    public function delete($id)
    {
        $feedback = Feedback::find($id);
        $feedback->delete();
        return $feedback;
    }
}