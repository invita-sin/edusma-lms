<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_students');
    }

    public function view(User $user, Student $student): bool
    {
        return $user->can('view_students')
            && ($user->hasRole('super-admin') || $user->student?->id === $student->id);
    }

    public function create(User $user): bool
    {
        return $user->can('create_students');
    }

    public function update(User $user, Student $student): bool
    {
        return $user->can('update_students')
            && ($user->hasRole('super-admin') || $user->student?->id === $student->id);
    }

    public function delete(User $user, Student $student): bool
    {
        return $user->can('delete_students')
            && ($user->hasRole('super-admin') || $user->student?->id === $student->id);
    }
}
