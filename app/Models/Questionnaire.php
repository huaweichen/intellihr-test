<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'questionnaire_id',
        'question_id',
        'required',
    ];

    public function question()
    {
        return $this->hasOne(Question::class, 'id', 'question_id');
    }
}
