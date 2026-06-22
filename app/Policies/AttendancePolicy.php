<?php

namespace App\Policies;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttendancePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_attendances');
    }

    public function view(User $user, Attendance $attendance): bool
    {
        return $user->can('view_attendances')
            && ($user->hasRole('super-admin') || $user->student?->id === $attendance->student_id || $user->teacher?->id === $attendance->teacher_id);
    }

    public function create(User $user): bool
    {
        return $user->can('create_attendances');
    }

    public function update(User $user, Attendance $attendance): bool
    {
        return $user->can('update_attendances')
            && ($user->hasRole('super-admin') || $user->student?->id === $attendance->student_id || $user->teacher?->id === $attendance->teacher_id);
    }

    public function delete(User $user, Attendance $attendance): bool
    {
        return $user->can('delete_attendances')
            && ($user->hasRole('super-admin') || $user->student?->id === $attendance->student_id || $user->teacher?->id === $attendance->teacher_id);
    }
}
