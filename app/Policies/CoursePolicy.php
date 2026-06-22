<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_courses');
    }

    public function view(User $user, Course $course): bool
    {
        return $user->can('view_courses')
            && ($user->hasRole('super-admin') || $user->teacher?->id === $course->teacher_id);
    }

    public function create(User $user): bool
    {
        return $user->can('create_courses');
    }

    public function update(User $user, Course $course): bool
    {
        return $user->can('update_courses')
            && ($user->hasRole('super-admin') || $user->teacher?->id === $course->teacher_id);
    }

    public function delete(User $user, Course $course): bool
    {
        return $user->can('delete_courses')
            && ($user->hasRole('super-admin') || $user->teacher?->id === $course->teacher_id);
    }
}
