<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'course_id',
        'academic_year_id',
        'semester_id',
        'assignment_score',
        'quiz_score',
        'midterm_score',
        'final_exam_score',
        'total_score',
        'grade',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'assignment_score' => 'decimal:2',
            'quiz_score' => 'decimal:2',
            'midterm_score' => 'decimal:2',
            'final_exam_score' => 'decimal:2',
            'total_score' => 'decimal:2',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }
}
