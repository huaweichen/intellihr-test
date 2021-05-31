<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use Illuminate\View\View;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $questionnaires = Questionnaire::select('questionnaire_id')
            ->distinct()
            ->pluck('questionnaire_id');

        return view('questionnaires.list', [
            'questionnaires' => $questionnaires
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function show(int $id): View
    {
        $questionnaires = Questionnaire::where('questionnaire_id', '=', $id)->get();

        $viewData = $questionnaires->map(function ($questionnaire) {
            $question = $questionnaire->question;
            return [
                'question_id' => $question->getKey(),
                'label' => $question->label,
                'type' => $question->type,
                'required' => $questionnaire->required,
                'options' => $question->options,
            ];
        });

        return view('questionnaires.show', [
            'questionnaireId' => $id,
            'questions' => $viewData->toArray()
        ]);
    }
}
