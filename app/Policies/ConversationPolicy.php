<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConversationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole('teacher') || $user->hasRole('student');
    }

    public function view(User $user, Conversation $conversation): bool
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }

        $teacher = $user->teacher;
        if ($teacher && $conversation->teacher_id === $teacher->id) {
            return true;
        }

        $student = $user->student;
        if ($student && $conversation->student_id === $student->id) {
            return true;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('teacher') || $user->hasRole('student');
    }

    public function sendMessage(User $user, Conversation $conversation): bool
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }

        $teacher = $user->teacher;
        if ($teacher && $conversation->teacher_id === $teacher->id) {
            return true;
        }

        $student = $user->student;
        if ($student && $conversation->student_id === $student->id) {
            return true;
        }

        return false;
    }
}
