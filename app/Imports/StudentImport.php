<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row): Student
    {
        $user = User::create([
            'name' => $row['nama'],
            'email' => $row['email'],
            'password' => Hash::make(Str::random(16)),
        ]);
        $user->assignRole('student');

        return new Student([
            'user_id' => $user->id,
            'nisn' => $row['nisn'],
            'nis' => $row['nis'],
            'classroom_id' => $row['classroom_id'] ?? null,
            'phone' => $row['phone'] ?? null,
            'address' => $row['address'] ?? null,
            'gender' => $row['gender'],
            'birth_date' => $row['birth_date'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nisn' => 'required|string|max:20|unique:students,nisn',
            'nis' => 'required|string|max:20|unique:students,nis',
            'gender' => 'required|in:L,P',
        ];
    }
}
