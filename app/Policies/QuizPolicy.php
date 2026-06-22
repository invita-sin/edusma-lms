<?php

namespace App\Policies;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuizPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_quizzes');
    }

    public function view(User $user, Quiz $quiz): bool
    {
        return $user->can('view_quizzes')
            && ($user->hasRole('super-admin') || $user->teacher?->id === \App\Models\Course::where('id', $quiz->course_id)->value('teacher_id'));
    }

    public function create(User $user): bool
    {
        return $user->can('create_quizzes');
    }

    public function update(User $user, Quiz $quiz): bool
    {
        return $user->can('update_quizzes')
            && ($user->hasRole('super-admin') || $user->teacher?->id === \App\Models\Course::where('id', $quiz->course_id)->value('teacher_id'));
    }

    public function delete(User $user, Quiz $quiz): bool
    {
        return $user->can('delete_quizzes')
            && ($user->hasRole('super-admin') || $user->teacher?->id === \App\Models\Course::where('id', $quiz->course_id)->value('teacher_id'));
    }
}
