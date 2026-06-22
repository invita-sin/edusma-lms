<?php

namespace App\Policies;

use App\Models\Assignment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssignmentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_assignments');
    }

    public function view(User $user, Assignment $assignment): bool
    {
        return $user->can('view_assignments')
            && ($user->hasRole('super-admin') || $user->teacher?->id === $assignment->teacher_id);
    }

    public function create(User $user): bool
    {
        return $user->can('create_assignments');
    }

    public function update(User $user, Assignment $assignment): bool
    {
        return $user->can('update_assignments')
            && ($user->hasRole('super-admin') || $user->teacher?->id === $assignment->teacher_id);
    }

    public function delete(User $user, Assignment $assignment): bool
    {
        return $user->can('delete_assignments')
            && ($user->hasRole('super-admin') || $user->teacher?->id === $assignment->teacher_id);
    }
}
