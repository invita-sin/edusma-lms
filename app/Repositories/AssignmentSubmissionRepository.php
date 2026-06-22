<?php

namespace App\Repositories;

use App\Models\AssignmentSubmission;
use Illuminate\Database\Eloquent\Collection;

class AssignmentSubmissionRepository
{
    public function findById(int $id): ?AssignmentSubmission
    {
        return AssignmentSubmission::with('assignment', 'student.user')->find($id);
    }

    public function create(array $data): AssignmentSubmission
    {
        return AssignmentSubmission::create($data);
    }

    public function update(int $id, array $data): AssignmentSubmission
    {
        $submission = AssignmentSubmission::findOrFail($id);
        $submission->update($data);
        return $submission;
    }

    public function getByAssignment(int $assignmentId): Collection
    {
        return AssignmentSubmission::where('assignment_id', $assignmentId)
            ->with('student.user')
            ->get();
    }

    public function getByStudent(int $studentId): Collection
    {
        return AssignmentSubmission::where('student_id', $studentId)
            ->with('assignment')
            ->get();
    }

    public function findByAssignmentAndStudent(int $assignmentId, int $studentId): ?AssignmentSubmission
    {
        return AssignmentSubmission::where('assignment_id', $assignmentId)
            ->where('student_id', $studentId)
            ->first();
    }
}
