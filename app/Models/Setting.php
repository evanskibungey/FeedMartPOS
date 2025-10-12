<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'description',
    ];

    /**
     * Get a setting value by key
     */
    public static function get(string $key, $default = null)
    {
        // Cache settings for 1 hour
        return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();

            if (!$setting) {
                return $default;
            }

            return self::castValue($setting->value, $setting->type);
        });
    }

    /**
     * Set a setting value
     */
    public static function set(string $key, $value, string $type = 'string', string $description = null): self
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'description' => $description,
            ]
        );

        // Clear cache for this setting
        Cache::forget("setting_{$key}");

        return $setting;
    }

    /**
     * Cast value based on type
     */
    protected static function castValue($value, string $type)
    {
        return match ($type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $value,
            'float' => (float) $value,
            'json' => json_decode($value, true),
            'image' => $value ? asset('storage/' . $value) : null,
            default => $value,
        };
    }

    /**
     * Get all settings as key-value pairs
     */
    public static function getAll(): array
    {
        return Cache::remember('all_settings', 3600, function () {
            $settings = self::all();
            $result = [];

            foreach ($settings as $setting) {
                $result[$setting->key] = self::castValue($setting->value, $setting->type);
            }

            return $result;
        });
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache(): void
    {
        Cache::forget('all_settings');

        $settings = self::all();
        foreach ($settings as $setting) {
            Cache::forget("setting_{$setting->key}");
        }
    }

    /**
     * Get system logo URL
     */
    public static function logo(): string
    {
        $logo = self::get('system_logo');
        return $logo ?: asset('images/logo.png');
    }

    /**
     * Get system name
     */
    public static function systemName(): string
    {
        return self::get('system_name', 'FeedMart POS');
    }

    /**
     * Get system currency
     */
    public static function currency(): string
    {
        return self::get('system_currency', 'KES');
    }

    /**
     * Get system currency symbol
     */
    public static function currencySymbol(): string
    {
        $currency = self::currency();

        $symbols = [
            'KES' => 'KES',
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'UGX' => 'UGX',
            'TZS' => 'TZS',
        ];

        return $symbols[$currency] ?? $currency;
    }
}
