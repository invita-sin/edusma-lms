<?php

namespace App\Services;

use App\DTOs\CreateMaterialDTO;
use App\DTOs\UpdateMaterialDTO;
use App\Models\Material;
use App\Repositories\MaterialRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MaterialService
{
    public function __construct(
        private readonly MaterialRepository $repository,
    ) {}

    public function create(CreateMaterialDTO $dto): Material
    {
        return $this->repository->create([
            'course_id' => $dto->courseId,
            'title' => $dto->title,
            'description' => $dto->description,
            'file_path' => $dto->filePath,
            'file_type' => $dto->fileType,
            'file_size' => $dto->fileSize,
            'url' => $dto->url,
            'order' => $dto->order,
        ]);
    }

    public function update(int $id, UpdateMaterialDTO $dto): Material
    {
        return $this->repository->update($id, [
            'course_id' => $dto->courseId,
            'title' => $dto->title,
            'description' => $dto->description,
            'file_path' => $dto->filePath,
            'file_type' => $dto->fileType,
            'file_size' => $dto->fileSize,
            'url' => $dto->url,
            'order' => $dto->order,
        ]);
    }

    public function delete(int $id): void
    {
        $material = $this->repository->findById($id);
        if ($material && $material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }
        $this->repository->delete($id);
    }

    public function findById(int $id): ?Material
    {
        return $this->repository->findById($id);
    }

    public function uploadFile(UploadedFile $file): string
    {
        return $file->store('materials', 'public');
    }

    public function getFileUrl(string $path): string
    {
        return Storage::disk('public')->url($path);
    }
}
