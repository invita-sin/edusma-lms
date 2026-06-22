<?php

namespace App\Repositories;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Collection;

class QuizRepository
{
    public function all(): Collection
    {
        return Quiz::with('course', 'teacher.user', 'questions.options')->get();
    }

    public function findById(int $id): ?Quiz
    {
        return Quiz::with('course', 'teacher.user', 'questions.options', 'attempts.student.user')->find($id);
    }

    public function create(array $data): Quiz
    {
        return Quiz::create($data);
    }

    public function update(int $id, array $data): Quiz
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->update($data);
        return $quiz;
    }

    public function delete(int $id): void
    {
        Quiz::destroy($id);
    }

    public function getByCourse(int $courseId): Collection
    {
        return Quiz::where('course_id', $courseId)->with('questions')->get();
    }

    public function getPublished(): Collection
    {
        return Quiz::where('is_published', true)->with('course', 'teacher.user')->get();
    }
}
