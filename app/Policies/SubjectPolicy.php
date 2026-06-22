<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubjectPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_subjects');
    }

    public function view(User $user, $subject): bool
    {
        return $user->can('view_subjects');
    }

    public function create(User $user): bool
    {
        return $user->can('create_subjects');
    }

    public function update(User $user, $subject): bool
    {
        return $user->can('update_subjects');
    }

    public function delete(User $user, $subject): bool
    {
        return $user->can('delete_subjects');
    }
}
