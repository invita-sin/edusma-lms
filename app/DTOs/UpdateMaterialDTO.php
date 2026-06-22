<?php

namespace App\DTOs;

readonly class UpdateMaterialDTO
{
    public function __construct(
        public int $courseId,
        public string $title,
        public ?string $description = null,
        public ?string $filePath = null,
        public ?string $fileType = null,
        public ?int $fileSize = null,
        public ?string $url = null,
        public int $order = 0,
    ) {}

    public function toArray(): array
    {
        return [
            'course_id' => $this->courseId,
            'title' => $this->title,
            'description' => $this->description,
            'file_path' => $this->filePath,
            'file_type' => $this->fileType,
            'file_size' => $this->fileSize,
            'url' => $this->url,
            'order' => $this->order,
        ];
    }
}
