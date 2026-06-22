<?php

namespace App\Services;

use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use App\Repositories\QuizAnswerRepository;
use App\Repositories\QuizAttemptRepository;

class ManualGradingService
{
    public function __construct(
        private readonly QuizAttemptRepository $attemptRepository,
        private readonly QuizAnswerRepository $answerRepository,
    ) {}

    public function getUngradedAnswers(int $quizId): array
    {
        return QuizAnswer::whereHas('attempt.quiz', fn($q) => $q->where('id', $quizId))
            ->whereHas('question', fn($q) => $q->where('type', 'essay'))
            ->whereNull('score')
            ->with('question', 'attempt.student.user')
            ->get()
            ->toArray();
    }

    public function gradeAnswer(int $answerId, int $score, ?string $feedback = null): QuizAnswer
    {
        $answer = QuizAnswer::with('question')->findOrFail($answerId);
        $maxPoints = $answer->question->points;
        $score = min(max($score, 0), $maxPoints);

        $this->answerRepository->update($answerId, [
            'score' => $score,
        ]);

        $attempt = $answer->attempt;
        $this->recalculateAttemptScore($attempt);

        return $answer->fresh();
    }

    private function recalculateAttemptScore(QuizAttempt $attempt): void
    {
        $allAnswers = $this->answerRepository->getByAttempt($attempt->id);
        $totalPoints = 0;
        $earnedPoints = 0;
        $allGraded = true;

        $questions = $attempt->quiz->questions;
        foreach ($questions as $question) {
            $totalPoints += $question->points;
            $ans = $allAnswers->firstWhere('quiz_question_id', $question->id);

            if ($question->type === 'multiple_choice') {
                if ($ans && $ans->score !== null) {
                    $earnedPoints += $ans->score;
                }
            } else {
                if ($ans && $ans->score !== null) {
                    $earnedPoints += $ans->score;
                } else {
                    $allGraded = false;
                }
            }
        }

        $this->attemptRepository->update($attempt->id, [
            'score' => $earnedPoints,
            'total_points' => $totalPoints,
            'is_graded' => $allGraded,
        ]);
    }
}
