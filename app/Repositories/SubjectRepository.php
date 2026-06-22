<?php

namespace App\Repositories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Collection;

class SubjectRepository
{
    public function all(): Collection
    {
        return Subject::all();
    }

    public function findById(int $id): ?Subject
    {
        return Subject::find($id);
    }

    public function findByCode(string $code): ?Subject
    {
        return Subject::where('code', $code)->first();
    }

    public function create(array $data): Subject
    {
        return Subject::create($data);
    }

    public function update(int $id, array $data): Subject
    {
        $subject = Subject::findOrFail($id);
        $subject->update($data);
        return $subject;
    }

    public function delete(int $id): void
    {
        Subject::destroy($id);
    }
}
