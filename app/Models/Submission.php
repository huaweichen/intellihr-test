<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'user_subject_id',
        'questionnaire_id',
        'question_id',
        'date',
        'response'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_subject_id', 'subject_id');
    }

    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class, 'questionnaire_id', 'questionnaire_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }
}
