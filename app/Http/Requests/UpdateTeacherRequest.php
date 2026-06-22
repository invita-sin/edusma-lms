<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->can('update_teachers') ?? false;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'nip' => ['required', 'string', 'max:30', 'unique:teachers,nip,' . $this->route('id')],
            'nuptk' => ['nullable', 'string', 'max:30'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'gender' => ['required', 'in:L,P'],
            'specialization' => ['nullable', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date'],
        ];
    }
}
