<?php

namespace App\Rules;

use App\Models\Question;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class QuestionOptionExists implements Rule
{
    /**
     * @var int
     */
    private $questionId;
    private $value;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!preg_match('/^question\.\d+$/', $attribute)) {
            return false;
        }

        $this->questionId = (int) Str::replace('question.', '', $attribute);
        $question = Question::find($this->questionId);

        if ($question->type !== 'select') {
            return true;
        }

        $this->value = $value;

        return $question->options->collect()->where('value', $value)->count() > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return sprintf('Question %d does not have option %s.', $this->questionId, $this->value);
    }
}
