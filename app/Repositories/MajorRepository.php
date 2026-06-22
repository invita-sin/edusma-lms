<?php

namespace App\Repositories;

use App\Models\Major;
use Illuminate\Database\Eloquent\Collection;

class MajorRepository
{
    public function all(): Collection
    {
        return Major::all();
    }

    public function findById(int $id): ?Major
    {
        return Major::find($id);
    }

    public function findByCode(string $code): ?Major
    {
        return Major::where('code', $code)->first();
    }

    public function create(array $data): Major
    {
        return Major::create($data);
    }

    public function update(int $id, array $data): Major
    {
        $major = Major::findOrFail($id);
        $major->update($data);
        return $major;
    }

    public function delete(int $id): void
    {
        Major::destroy($id);
    }
}
