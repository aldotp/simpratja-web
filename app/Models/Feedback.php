<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';

    protected $fillable = [
        'patient_id',
        'feedback_content',
        'feedback_date',
    ];
}