<?php

namespace App\Services;

use App\Models\Setting;

class SettingsService
{
    public function get(string $key, mixed $default = null): ?string
    {
        return Setting::getValue($key, $default);
    }

    public function set(string $key, ?string $value, string $group = 'general'): void
    {
        Setting::setValue($key, $value, $group);
    }

    public function getSchoolSettings(): array
    {
        return Setting::getGroup('school');
    }

    public function getAcademicSettings(): array
    {
        return Setting::getGroup('academic');
    }

    public function updateSchoolSettings(array $data): void
    {
        $settings = collect($data)->map(fn($value, $key) => [
            'key' => $key,
            'value' => $value,
            'group' => 'school',
        ])->toArray();

        Setting::upsert($settings, ['key'], ['value', 'group']);
    }

    public function updateAcademicSettings(array $data): void
    {
        $settings = collect($data)->map(fn($value, $key) => [
            'key' => $key,
            'value' => $value,
            'group' => 'academic',
        ])->toArray();

        Setting::upsert($settings, ['key'], ['value', 'group']);
    }
}
