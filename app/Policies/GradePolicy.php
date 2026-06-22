<?php

namespace App\Policies;

use App\Models\Grade;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GradePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_grades');
    }

    public function view(User $user, Grade $grade): bool
    {
        return $user->can('view_grades')
            && ($user->hasRole('super-admin') || $user->student?->id === $grade->student_id || $user->teacher?->id === \App\Models\Course::where('id', $grade->course_id)->value('teacher_id'));
    }

    public function create(User $user): bool
    {
        return $user->can('create_grades');
    }

    public function update(User $user, Grade $grade): bool
    {
        return $user->can('update_grades')
            && ($user->hasRole('super-admin') || $user->student?->id === $grade->student_id || $user->teacher?->id === \App\Models\Course::where('id', $grade->course_id)->value('teacher_id'));
    }

    public function delete(User $user, Grade $grade): bool
    {
        return $user->can('delete_grades')
            && ($user->hasRole('super-admin') || $user->student?->id === $grade->student_id || $user->teacher?->id === \App\Models\Course::where('id', $grade->course_id)->value('teacher_id'));
    }
}
