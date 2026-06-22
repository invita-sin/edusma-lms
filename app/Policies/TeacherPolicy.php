<?php

namespace App\Policies;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeacherPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_teachers');
    }

    public function view(User $user, Teacher $teacher): bool
    {
        return $user->can('view_teachers')
            && ($user->hasRole('super-admin') || $user->teacher?->id === $teacher->id);
    }

    public function create(User $user): bool
    {
        return $user->can('create_teachers');
    }

    public function update(User $user, Teacher $teacher): bool
    {
        return $user->can('update_teachers')
            && ($user->hasRole('super-admin') || $user->teacher?->id === $teacher->id);
    }

    public function delete(User $user, Teacher $teacher): bool
    {
        return $user->can('delete_teachers')
            && ($user->hasRole('super-admin') || $user->teacher?->id === $teacher->id);
    }
}
