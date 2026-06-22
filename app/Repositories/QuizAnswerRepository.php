<?php

namespace App\Repositories;

use App\Models\QuizAnswer;
use Illuminate\Database\Eloquent\Collection;

class QuizAnswerRepository
{
    public function create(array $data): QuizAnswer
    {
        return QuizAnswer::create($data);
    }

    public function update(int $id, array $data): QuizAnswer
    {
        $answer = QuizAnswer::findOrFail($id);
        $answer->update($data);
        return $answer;
    }

    public function createMany(array $answers): Collection
    {
        $models = new Collection();
        foreach ($answers as $data) {
            $models->push($this->create($data));
        }
        return $models;
    }

    public function getByAttempt(int $attemptId): Collection
    {
        return QuizAnswer::where('quiz_attempt_id', $attemptId)->with('question', 'selectedOption')->get();
    }
}
