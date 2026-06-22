<?php

namespace App\Services;

use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;
use App\Repositories\QuizAnswerRepository;
use App\Repositories\QuizAttemptRepository;

class AutoGradingService
{
    public function __construct(
        private readonly QuizAttemptRepository $attemptRepository,
        private readonly QuizAnswerRepository $answerRepository,
    ) {}

    public function grade(int $attemptId): QuizAttempt
    {
        $attempt = $this->attemptRepository->findById($attemptId);
        if (!$attempt) {
            throw new \RuntimeException('Attempt not found');
        }

        $questions = $attempt->quiz->questions()->with('options')->get();
        $answers = $this->answerRepository->getByAttempt($attemptId);

        $totalPoints = 0;
        $earnedPoints = 0;

        foreach ($questions as $question) {
            $totalPoints += $question->points;

            $answer = $answers->firstWhere('quiz_question_id', $question->id);
            if (!$answer) {
                continue;
            }

            if ($question->type === 'multiple_choice') {
                $correctOption = $question->options->firstWhere('is_correct', true);
                if ($correctOption && $answer->quiz_option_id === $correctOption->id) {
                    $this->answerRepository->update($answer->id, ['score' => $question->points]);
                    $earnedPoints += $question->points;
                } else {
                    $this->answerRepository->update($answer->id, ['score' => 0]);
                }
            }
        }

        $attempt->score = $earnedPoints;
        $attempt->total_points = $totalPoints;
        $attempt->is_graded = true;
        $attempt->ended_at = now();
        $attempt->save();

        return $attempt;
    }

    public function gradeManual(int $answerId, int $score): void
    {
        $answer = QuizAnswer::with('question')->find($answerId);
        if (!$answer || $answer->question->type !== 'essay') {
            throw new \RuntimeException('Invalid answer or not an essay question');
        }

        $maxPoints = $answer->question->points;
        $score = min($score, $maxPoints);

        $this->answerRepository->update($answerId, ['score' => $score]);

        $attempt = $answer->attempt;
        $allAnswers = $this->answerRepository->getByAttempt($attempt->id);

        $totalScore = 0;
        $totalPoints = 0;
        $allGraded = true;

        $questions = $attempt->quiz->questions;
        foreach ($questions as $question) {
            $totalPoints += $question->points;
            $ans = $allAnswers->firstWhere('quiz_question_id', $question->id);
            if ($ans && $ans->score !== null) {
                $totalScore += $ans->score;
            } elseif ($question->type === 'multiple_choice') {
                if ($ans) {
                    $totalScore += $ans->score ?? 0;
                }
            } else {
                $allGraded = false;
            }
        }

        if ($allGraded) {
            $this->attemptRepository->update($attempt->id, [
                'score' => $totalScore,
                'total_points' => $totalPoints,
                'is_graded' => true,
            ]);
        }
    }
}
