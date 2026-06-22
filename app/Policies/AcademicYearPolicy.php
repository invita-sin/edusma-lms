<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AcademicYearPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_academic_years');
    }

    public function view(User $user, $academicYear): bool
    {
        return $user->can('view_academic_years');
    }

    public function create(User $user): bool
    {
        return $user->can('create_academic_years');
    }

    public function update(User $user, $academicYear): bool
    {
        return $user->can('update_academic_years');
    }

    public function delete(User $user, $academicYear): bool
    {
        return $user->can('delete_academic_years');
    }
}
