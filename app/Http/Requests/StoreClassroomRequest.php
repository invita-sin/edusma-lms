<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassroomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->can('create_classrooms') ?? false;
    }

    public function rules(): array
    {
        return [
            'major_id' => ['required', 'exists:majors,id'],
            'name' => ['required', 'string', 'max:100'],
            'level' => ['required', 'in:10,11,12'],
            'capacity' => ['required', 'integer', 'min:1', 'max:100'],
        ];
    }
}
