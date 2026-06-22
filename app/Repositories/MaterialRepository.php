<?php

namespace App\Repositories;

use App\Models\Material;
use Illuminate\Database\Eloquent\Collection;

class MaterialRepository
{
    public function all(): Collection
    {
        return Material::with('course')->get();
    }

    public function findById(int $id): ?Material
    {
        return Material::with('course')->find($id);
    }

    public function create(array $data): Material
    {
        return Material::create($data);
    }

    public function update(int $id, array $data): Material
    {
        $material = Material::findOrFail($id);
        $material->update($data);
        return $material;
    }

    public function delete(int $id): void
    {
        Material::destroy($id);
    }

    public function getByCourse(int $courseId): Collection
    {
        return Material::where('course_id', $courseId)->orderBy('order')->get();
    }
}
