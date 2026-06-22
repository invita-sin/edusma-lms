<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'group'];

    protected function casts(): array
    {
        return [
            'value' => 'string',
        ];
    }

    public static function getValue(string $key, mixed $default = null): ?string
    {
        return Cache::rememberForever("setting_{$key}", function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    public static function setValue(string $key, ?string $value, string $group = 'general'): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );
        Cache::forget("setting_{$key}");
    }

    public static function getGroup(string $group): array
    {
        return Cache::rememberForever("setting_group_{$group}", function () use ($group) {
            return static::where('group', $group)->pluck('value', 'key')->toArray();
        });
    }

    protected static function booted(): void
    {
        static::saved(fn() => Cache::forget('setting_group_general'));
        static::saved(fn() => Cache::forget('setting_group_school'));
        static::saved(fn() => Cache::forget('setting_group_academic'));
    }
}
