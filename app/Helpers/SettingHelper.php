<?php

namespace App\Helpers;

use App\Models\Pengaturan;
use Illuminate\Support\Facades\Cache;

class SettingHelper
{
    public static function get(string $key, $default = null)
    {
        return Cache::remember("setting.{$key}", 3600, function () use ($key, $default) {
            return Pengaturan::get($key, $default);
        });
    }

    public static function set(string $key, $value): void
    {
        Pengaturan::set($key, $value);
        Cache::forget("setting.{$key}");
    }

    public static function forget(string $key): void
    {
        Cache::forget("setting.{$key}");
    }

    public static function clearAll(): void
    {
        Cache::flush();
    }
}