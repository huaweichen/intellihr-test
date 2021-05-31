<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Questionnaire;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User
        User::factory(10)->create();

        if (User::where('subject_id', '=', 'GLaDOS')->count() === 0) {
            User::factory(1)->gladosUser()->create();
        }

        // Question
        Question::factory(5)->create();
        Question::factory(3)->selectQuestion()->create();

        // Questionnaire
        $questions = Question::all();
        $this->createQuestionnaire($questions, 3);
        $this->createQuestionnaire($questions, 6);
        $this->createQuestionnaire($questions, 8);

        // Submission
        $questionnaires = Questionnaire::all()->mapToGroups(function (Questionnaire $questionnaire) {
            return [
                $questionnaire->questionnaire_id => $questionnaire
            ];
        });
        $this->createSubmission($questionnaires);
    }

    protected function createQuestionnaire(Collection $questions, int $numberOfQuestions)
    {
        $shuffledQuestions = $questions->shuffle()->take($numberOfQuestions);
        $questionnaireId = Questionnaire::max('questionnaire_id') + 1;

        $shuffledQuestions->each(function ($shuffledQuestion) use ($questionnaireId) {
            Questionnaire::factory()->state([
                'questionnaire_id' => $questionnaireId,
                'question_id' => $shuffledQuestion->getKey(),
            ])->create();
        });
    }

    protected function createSubmission(Collection $questionnaires)
    {
        $shuffledQuestionnaires = $questionnaires->shuffle();

        $shuffledQuestionnaires->each(function ($shuffledQuestionnaireCollection) {
            $submissionId = Submission::max('submission_id') + 1;
            $subjectUser = User::where('alive', '=', true)
                ->where('role', '=', 'Subject')
                ->get()
                ->shuffle()
                ->take(1);
            $shuffledQuestionnaireCollection->each(function ($questionnaire) use ($subjectUser, $submissionId) {
                $question = Question::findOrFail($questionnaire->question_id);
                Submission::factory()->state([
                    'submission_id' => $submissionId,
                    'user_subject_id' => $subjectUser->first()->getKey(),
                    'questionnaire_id' => $questionnaire->questionnaire_id,
                    'question_id' => $question->getKey(),
                    'response' => $question->options === null ? 'A' : 'text response'
                ])->create();
            });
        });
    }
}
