<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MajorPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_majors');
    }

    public function view(User $user, $major): bool
    {
        return $user->can('view_majors');
    }

    public function create(User $user): bool
    {
        return $user->can('create_majors');
    }

    public function update(User $user, $major): bool
    {
        return $user->can('update_majors');
    }

    public function delete(User $user, $major): bool
    {
        return $user->can('delete_majors');
    }
}
