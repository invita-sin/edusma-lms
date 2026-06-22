<?php

namespace App\Imports;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class TeacherImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row): Teacher
    {
        $user = User::create([
            'name' => $row['nama'],
            'email' => $row['email'],
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('teacher');

        return new Teacher([
            'user_id' => $user->id,
            'nip' => $row['nip'],
            'nuptk' => $row['nuptk'] ?? null,
            'phone' => $row['phone'] ?? null,
            'address' => $row['address'] ?? null,
            'gender' => $row['gender'],
            'specialization' => $row['specialization'] ?? null,
            'birth_date' => $row['birth_date'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nip' => 'required|string|max:30|unique:teachers,nip',
            'gender' => 'required|in:L,P',
        ];
    }
}
