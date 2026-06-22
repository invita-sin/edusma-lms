<?php

namespace App\Services;

use App\DTOs\CreateQuizDTO;
use App\DTOs\UpdateQuizDTO;
use App\DTOs\CreateQuestionDTO;
use App\DTOs\CreateAttemptDTO;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizOption;
use App\Models\QuizAttempt;
use App\Repositories\QuizRepository;
use App\Repositories\QuizAttemptRepository;
use App\Repositories\QuizAnswerRepository;

class QuizService
{
    public function __construct(
        private readonly QuizRepository $repository,
        private readonly QuizAttemptRepository $attemptRepository,
        private readonly QuizAnswerRepository $answerRepository,
        private readonly AutoGradingService $autoGradingService,
        private readonly RandomQuestionEngine $randomQuestionEngine,
    ) {}

    public function create(CreateQuizDTO $dto): Quiz
    {
        return $this->repository->create([
            'course_id' => $dto->courseId,
            'teacher_id' => $dto->teacherId,
            'title' => $dto->title,
            'description' => $dto->description,
            'time_limit' => $dto->timeLimit,
            'passing_score' => $dto->passingScore,
            'is_random' => $dto->isRandom,
            'is_published' => $dto->isPublished,
            'start_date' => $dto->startDate,
            'end_date' => $dto->endDate,
        ]);
    }

    public function update(int $id, UpdateQuizDTO $dto): Quiz
    {
        return $this->repository->update($id, [
            'course_id' => $dto->courseId,
            'teacher_id' => $dto->teacherId,
            'title' => $dto->title,
            'description' => $dto->description,
            'time_limit' => $dto->timeLimit,
            'passing_score' => $dto->passingScore,
            'is_random' => $dto->isRandom,
            'is_published' => $dto->isPublished,
            'start_date' => $dto->startDate,
            'end_date' => $dto->endDate,
        ]);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    public function findById(int $id): ?Quiz
    {
        return $this->repository->findById($id);
    }

    public function addQuestion(CreateQuestionDTO $dto): QuizQuestion
    {
        $question = QuizQuestion::create([
            'quiz_id' => $dto->quizId,
            'question' => $dto->question,
            'type' => $dto->type,
            'points' => $dto->points,
            'order' => $dto->order,
        ]);

        if ($dto->options && $dto->type === 'multiple_choice') {
            foreach ($dto->options as $opt) {
                QuizOption::create([
                    'quiz_question_id' => $question->id,
                    'option' => $opt['option'],
                    'is_correct' => $opt['is_correct'] ?? false,
                ]);
            }
        }

        return $question->load('options');
    }

    public function getQuestions(int $quizId): array
    {
        $quiz = $this->repository->findById($quizId);
        if (!$quiz) {
            return [];
        }

        if ($quiz->is_random) {
            return $this->randomQuestionEngine->shuffle($quiz)->toArray();
        }

        return $quiz->questions()->with('options')->orderBy('order')->get()->toArray();
    }

    public function startAttempt(CreateAttemptDTO $dto): QuizAttempt
    {
        $attempt = $this->attemptRepository->create([
            'quiz_id' => $dto->quizId,
            'student_id' => $dto->studentId,
            'started_at' => now(),
            'total_points' => 0,
        ]);

        return $attempt;
    }

    public function submitAttempt(int $attemptId, array $answers): QuizAttempt
    {
        $attempt = $this->attemptRepository->findById($attemptId);
        if (!$attempt) {
            throw new \RuntimeException('Attempt not found');
        }

        $quiz = $this->repository->findById($attempt->quiz_id);
        $validQuestionIds = $quiz->questions->pluck('id')->toArray();

        foreach ($answers as $answer) {
            if (!in_array($answer['question_id'], $validQuestionIds)) {
                throw new \InvalidArgumentException("Question ID {$answer['question_id']} is not part of this quiz.");
            }
        }

        $answerData = [];
        foreach ($answers as $ans) {
            $answerData[] = [
                'quiz_attempt_id' => $attemptId,
                'quiz_question_id' => $ans['question_id'],
                'quiz_option_id' => $ans['option_id'] ?? null,
                'text_answer' => $ans['text_answer'] ?? null,
            ];
        }
        $this->answerRepository->createMany($answerData);

        $gradedAttempt = $this->autoGradingService->grade($attemptId);

        $this->attemptRepository->update($attemptId, [
            'score' => $gradedAttempt->score,
            'total_points' => $gradedAttempt->total_points,
            'ended_at' => now(),
            'is_graded' => true,
        ]);

        return $this->attemptRepository->findById($attemptId);
    }

    public function gradeManually(int $answerId, int $score): void
    {
        $this->autoGradingService->gradeManual($answerId, $score);
    }
}
