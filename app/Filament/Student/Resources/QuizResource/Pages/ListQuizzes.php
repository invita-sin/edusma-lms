<?php

namespace App\Filament\Student\Resources\QuizResource\Pages;

use App\Filament\Student\Resources\QuizResource;
use Filament\Resources\Pages\ListRecords;

class ListQuizzes extends ListRecords
{
    protected static string $resource = QuizResource::class;
}
