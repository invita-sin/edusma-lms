<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->can('update_courses') ?? false;
    }

    public function rules(): array
    {
        return [
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'semester_id' => ['required', 'exists:semesters,id'],
            'classroom_id' => ['required', 'exists:classrooms,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'code' => ['required', 'string', 'max:50', 'unique:courses,code,' . $this->route('id')],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'total_hours' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
