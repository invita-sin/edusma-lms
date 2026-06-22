<?php

namespace App\Services;

use App\DTOs\CreateAssignmentDTO;
use App\DTOs\UpdateAssignmentDTO;
use App\DTOs\CreateSubmissionDTO;
use App\DTOs\GradeSubmissionDTO;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Repositories\AssignmentRepository;
use App\Repositories\AssignmentSubmissionRepository;
use App\Notifications\AssignmentCreatedNotification;
use Illuminate\Support\Facades\Notification;

class AssignmentService
{
    public function __construct(
        private readonly AssignmentRepository $repository,
        private readonly AssignmentSubmissionRepository $submissionRepository,
    ) {}

    public function create(CreateAssignmentDTO $dto): Assignment
    {
        $assignment = $this->repository->create([
            'course_id' => $dto->courseId,
            'teacher_id' => $dto->teacherId,
            'title' => $dto->title,
            'description' => $dto->description,
            'file_path' => $dto->filePath,
            'type' => $dto->type,
            'max_score' => $dto->maxScore,
            'due_date' => $dto->dueDate,
        ]);

        $assignment->load('course.classroom.students.user');
        $course = $assignment->course;
        if ($course && $course->classroom && $course->classroom->students) {
            $course->classroom->students->each(function ($student) use ($assignment) {
                if ($student && $student->user) {
                    Notification::send($student->user, new AssignmentCreatedNotification($assignment));
                }
            });
        }

        return $assignment;
    }

    public function update(int $id, UpdateAssignmentDTO $dto): Assignment
    {
        return $this->repository->update($id, [
            'course_id' => $dto->courseId,
            'teacher_id' => $dto->teacherId,
            'title' => $dto->title,
            'description' => $dto->description,
            'file_path' => $dto->filePath,
            'type' => $dto->type,
            'max_score' => $dto->maxScore,
            'due_date' => $dto->dueDate,
        ]);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    public function findById(int $id): ?Assignment
    {
        return $this->repository->findById($id);
    }

    public function submit(int $assignmentId, CreateSubmissionDTO $dto): AssignmentSubmission
    {
        return $this->submissionRepository->create([
            'assignment_id' => $dto->assignmentId,
            'student_id' => $dto->studentId,
            'content' => $dto->content,
            'file_path' => $dto->filePath,
            'submitted_at' => now(),
        ]);
    }

    public function grade(int $submissionId, GradeSubmissionDTO $dto): AssignmentSubmission
    {
        return $this->submissionRepository->update($submissionId, [
            'score' => $dto->score,
            'feedback' => $dto->feedback,
            'graded_at' => now(),
        ]);
    }
}
