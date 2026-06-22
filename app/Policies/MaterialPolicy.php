<?php

namespace App\Policies;

use App\Models\Material;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaterialPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_materials');
    }

    public function view(User $user, Material $material): bool
    {
        return $user->can('view_materials')
            && ($user->hasRole('super-admin') || $user->teacher?->id === \App\Models\Course::where('id', $material->course_id)->value('teacher_id'));
    }

    public function create(User $user): bool
    {
        return $user->can('create_materials');
    }

    public function update(User $user, Material $material): bool
    {
        return $user->can('update_materials')
            && ($user->hasRole('super-admin') || $user->teacher?->id === \App\Models\Course::where('id', $material->course_id)->value('teacher_id'));
    }

    public function delete(User $user, Material $material): bool
    {
        return $user->can('delete_materials')
            && ($user->hasRole('super-admin') || $user->teacher?->id === \App\Models\Course::where('id', $material->course_id)->value('teacher_id'));
    }
}
