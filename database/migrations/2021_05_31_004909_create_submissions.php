<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->integer('submission_id')->nullable(false);
            $table->dateTimeTz('date')->comment('Actually is date and time with timezone, but respect the data.json.');
            $table->foreignUuid('user_subject_id')->references('subject_id')->on('users');
            $table->integer('questionnaire_id');
            $table->foreignId('question_id')->references('id')->on('questions');
            $table->string('response')->nullable()->comment('The response to each question in each questionnaire.');
            $table->timestamps();
            $table->unique(['submission_id', 'user_subject_id', 'questionnaire_id', 'question_id'], 'unique_submission');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submissions');
    }
}
