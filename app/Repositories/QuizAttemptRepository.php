<?php

namespace App\Repositories;

use App\Models\QuizAttempt;
use Illuminate\Database\Eloquent\Collection;

class QuizAttemptRepository
{
    public function findById(int $id): ?QuizAttempt
    {
        return QuizAttempt::with('quiz.questions.options', 'student.user', 'answers.selectedOption', 'answers.question')->find($id);
    }

    public function create(array $data): QuizAttempt
    {
        return QuizAttempt::create($data);
    }

    public function update(int $id, array $data): QuizAttempt
    {
        $attempt = QuizAttempt::findOrFail($id);
        $attempt->update($data);
        return $attempt;
    }

    public function getByQuiz(int $quizId): Collection
    {
        return QuizAttempt::where('quiz_id', $quizId)->with('student.user')->get();
    }

    public function getByStudent(int $studentId): Collection
    {
        return QuizAttempt::where('student_id', $studentId)->with('quiz')->get();
    }

    public function findByStudentAndQuiz(int $studentId, int $quizId): Collection
    {
        return QuizAttempt::where('student_id', $studentId)->where('quiz_id', $quizId)->get();
    }
}
