<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
        'label',
        'description',
    ];

    /**
     * Get cached site settings as key-value dictionary.
     */
    public static function getAllGrouped(): array
    {
        return Cache::rememberForever('site_settings_all', function () {
            $settings = self::all();
            $grouped = [];
            foreach ($settings as $setting) {
                $grouped[$setting->key] = $setting->value;
            }
            return $grouped;
        });
    }

    /**
     * Retrieve single setting value by key.
     */
    public static function get(string $key, $default = null)
    {
        $all = self::getAllGrouped();
        return $all[$key] ?? $default;
    }

    /**
     * Set or update setting.
     */
    public static function set(string $key, $value, string $group = 'general', string $type = 'text', ?string $label = null): self
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'type' => $type,
                'label' => $label ?? ucwords(str_replace('_', ' ', $key)),
            ]
        );

        Cache::forget('site_settings_all');
        return $setting;
    }

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('site_settings_all');
        });
        static::deleted(function () {
            Cache::forget('site_settings_all');
        });
    }
}

