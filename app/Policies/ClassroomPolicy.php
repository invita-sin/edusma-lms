<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClassroomPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_classrooms');
    }

    public function view(User $user, $classroom): bool
    {
        return $user->can('view_classrooms');
    }

    public function create(User $user): bool
    {
        return $user->can('create_classrooms');
    }

    public function update(User $user, $classroom): bool
    {
        return $user->can('update_classrooms');
    }

    public function delete(User $user, $classroom): bool
    {
        return $user->can('delete_classrooms');
    }
}
