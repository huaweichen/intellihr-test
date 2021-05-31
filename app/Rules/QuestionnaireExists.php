<?php

namespace App\Rules;

use App\Models\Questionnaire;
use Illuminate\Contracts\Validation\Rule;

class QuestionnaireExists implements Rule
{
    /**
     * @var int
     */
    private $questionnaireId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $this->questionnaireId = (int) $value;
        $questionnaire = Questionnaire::where('questionnaire_id', '=', $this->questionnaireId);

        return $questionnaire !== null;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return sprintf('Questionnaire %d does not exist.', $this->questionnaireId);
    }
}
