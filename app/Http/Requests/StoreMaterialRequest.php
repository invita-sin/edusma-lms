<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaterialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->can('create_materials') ?? false;
    }

    public function rules(): array
    {
        return [
            'course_id' => ['required', 'exists:courses,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'file' => ['nullable', 'file', 'max:102400'],
            'url' => ['nullable', 'url', 'max:2048'],
            'order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
