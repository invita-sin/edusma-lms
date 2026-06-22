<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SemesterPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_semesters');
    }

    public function view(User $user, $semester): bool
    {
        return $user->can('view_semesters');
    }

    public function create(User $user): bool
    {
        return $user->can('create_semesters');
    }

    public function update(User $user, $semester): bool
    {
        return $user->can('update_semesters');
    }

    public function delete(User $user, $semester): bool
    {
        return $user->can('delete_semesters');
    }
}
