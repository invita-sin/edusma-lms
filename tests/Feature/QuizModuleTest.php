<?php

use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('db:seed', ['--class' => 'RoleAndPermissionSeeder']);
});

it('can create a quiz with questions', function () {
    $quiz = Quiz::create([
        'course_id' => Course::factory()->create()->id,
        'teacher_id' => Teacher::factory()->create()->id,
        'title' => 'Quiz Matematika',
        'time_limit' => 30,
        'passing_score' => 70,
    ]);

    expect($quiz->title)->toBe('Quiz Matematika');
});

it('auto grades multiple choice correctly', function () {
    $quiz = Quiz::factory()->create();
    $question = QuizQuestion::factory()->create([
        'quiz_id' => $quiz->id,
        'type' => 'multiple_choice',
        'points' => 10,
    ]);
    $correctOption = \App\Models\QuizOption::factory()->create([
        'quiz_question_id' => $question->id,
        'is_correct' => true,
    ]);
    $wrongOption = \App\Models\QuizOption::factory()->create([
        'quiz_question_id' => $question->id,
        'is_correct' => false,
    ]);

    $attempt = \App\Models\QuizAttempt::factory()->create([
        'quiz_id' => $quiz->id,
        'total_points' => 10,
    ]);

    $answer = \App\Models\QuizAnswer::create([
        'quiz_attempt_id' => $attempt->id,
        'quiz_question_id' => $question->id,
        'quiz_option_id' => $correctOption->id,
    ]);

    $service = app(\App\Services\AutoGradingService::class);
    $attempt = $service->grade($answer->quiz_attempt_id);

    expect($attempt->score)->toBe(10);
});

it('can shuffle questions via RandomQuestionEngine', function () {
    $quiz = Quiz::factory()->create();
    QuizQuestion::factory()->count(5)->create(['quiz_id' => $quiz->id]);

    $engine = app(\App\Services\RandomQuestionEngine::class);
    $shuffled = $engine->shuffle($quiz);

    expect($shuffled)->toHaveCount(5);
});

it('can grade essay manually', function () {
    $quiz = Quiz::factory()->create();
    $question = QuizQuestion::factory()->create([
        'quiz_id' => $quiz->id,
        'type' => 'essay',
        'points' => 20,
    ]);
    $attempt = \App\Models\QuizAttempt::factory()->create([
        'quiz_id' => $quiz->id,
        'total_points' => 20,
    ]);
    $answer = \App\Models\QuizAnswer::create([
        'quiz_attempt_id' => $attempt->id,
        'quiz_question_id' => $question->id,
        'text_answer' => 'Jawaban essay',
    ]);

    $service = app(\App\Services\ManualGradingService::class);
    $graded = $service->gradeAnswer($answer->id, 15);

    expect($graded->score)->toBe(15);
});
