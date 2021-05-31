<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Rules\QuestionExists;
use App\Rules\QuestionnaireExists;
use App\Rules\QuestionOptionExists;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class SubmissionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        try {
            $this->authorize('viewAny', Submission::class);
            $submissions = Submission::all();
        } catch (AuthorizationException $e) {
            $submissions = Submission::where('user_subject_id', '=', Auth::user()->subject_id)->get();
        }

        if ($submissions->count() === 0) {
            return view('submissions.list', [
                'submissions' => []
            ]);
        }

        $listData = $submissions->mapToGroups(function ($submission) {
            return [
                $submission->submission_id => [
                    'questionnaire' => $submission->questionnaire_id,
                    'user' => $submission->user_subject_id,
                    'date' => $submission->date,
                    'question_id' => $submission->question_id,
                    'label' => $submission->question->label,
                    'response' => $submission->response,
                ]
            ];
        });

        return view('submissions.list', [
            'submissions' => $listData
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        Validator::make($request->all(), [
            'questionnaire_id' => ['required', new QuestionnaireExists()],
            'question.*' => [
                new QuestionOptionExists(),
                new QuestionExists(),
            ]
        ])->validate();

        $questionnaireId = $request->get('questionnaire_id');
        $questions = $request->get('question');
        $currentTime = Carbon::now();
        $submissionId = (int) Submission::max('submission_id') + 1;

        $bulkInsert = [];
        foreach ($questions as $questionId => $response) {
            $bulkInsert[] = [
                'submission_id' => $submissionId,
                'user_subject_id' => Auth::user()->subject_id,
                'questionnaire_id' => $questionnaireId,
                'question_id' => $questionId,
                'response' => $response,
                'date' => $currentTime
            ];
        }

        Submission::insert($bulkInsert);

        return redirect()->route('submissions.show', ['submission' => $submissionId]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return View
     * @throws AuthorizationException
     */
    public function show(int $id): View
    {
        $submissions = Submission::where('submission_id', '=', $id)->get();

        $this->authorize('view', $submissions->first());

        $viewData = $submissions->map(function ($submission) {
            $question = $submission->question;
            return [
                'label' => $question->label,
                'response' => $submission->response
            ];
        });

        return view('submissions.show', [
            'submissionId' => $id,
            'userSubjectId' => $submissions->first()->user_subject_id,
            'questionnaireId' => $submissions->first()->questionnaire_id,
            'date' => $submissions->first()->date,
            'responses' => $viewData->toArray(),
        ]);
    }
}
