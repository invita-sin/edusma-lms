<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id',
        'teacher_id',
        'title',
        'description',
        'time_limit',
        'passing_score',
        'is_random',
        'is_published',
        'start_date',
        'end_date',
    ];

    protected function casts(): array
    {
        return [
            'is_random' => 'boolean',
            'is_published' => 'boolean',
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'passing_score' => 'integer',
            'time_limit' => 'integer',
        ];
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }
}
