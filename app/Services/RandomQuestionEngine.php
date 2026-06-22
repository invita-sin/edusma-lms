<?php

namespace App\Services;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Collection;

class RandomQuestionEngine
{
    public function shuffle(Quiz $quiz): Collection
    {
        $questions = $quiz->questions()->with('options')->get();

        $shuffled = $questions->shuffle();

        $shuffled->each(function ($question) {
            if ($question->type === 'multiple_choice') {
                $question->setRelation('options', $question->options->shuffle());
            }
        });

        return $shuffled;
    }

    public function shuffleWithLimit(Quiz $quiz, int $limit): Collection
    {
        $questions = $quiz->questions()->with('options')->get();

        $shuffled = $questions->shuffle()->take($limit);

        $shuffled->each(function ($question) {
            if ($question->type === 'multiple_choice') {
                $question->setRelation('options', $question->options->shuffle());
            }
        });

        return $shuffled;
    }
}
