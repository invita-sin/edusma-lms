<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->can('update_students') ?? false;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'classroom_id' => ['nullable', 'exists:classrooms,id'],
            'nisn' => ['required', 'string', 'max:20', 'unique:students,nisn,' . $this->route('id')],
            'nis' => ['required', 'string', 'max:20', 'unique:students,nis,' . $this->route('id')],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'gender' => ['required', 'in:L,P'],
            'birth_date' => ['nullable', 'date'],
        ];
    }
}
