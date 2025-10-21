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
        Cache::forget('all_settings');

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
        
        // If custom logo exists, return it
        if ($logo) {
            return $logo;
        }
        
        // Return default fallback logo
        return asset('images/logo.png');
    }

    /**
     * Get raw logo path (without asset url)
     */
    public static function logoPath(): ?string
    {
        $setting = self::where('key', 'system_logo')->first();
        return $setting ? $setting->value : null;
    }

    /**
     * Get system name
     */
    public static function systemName(): string
    {
        return self::get('system_name', config('app.name', 'FeedMart POS'));
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

    /**
     * Format currency amount
     */
    public static function formatCurrency(float $amount): string
    {
        $symbol = self::currencySymbol();
        return $symbol . ' ' . number_format($amount, 2);
    }

    /**
     * Get system email
     */
    public static function email(): string
    {
        return self::get('system_email', config('mail.from.address', 'info@feedmart.com'));
    }

    /**
     * Get system phone
     */
    public static function phone(): string
    {
        return self::get('system_phone', '+254 700 000 000');
    }

    /**
     * Get system address
     */
    public static function address(): string
    {
        return self::get('system_address', 'Nairobi, Kenya');
    }

    /**
     * Get system tagline
     */
    public static function tagline(): string
    {
        return self::get('system_tagline', 'Agriculture & Animal Feed Solutions');
    }

    /**
     * Get tax rate
     */
    public static function taxRate(): float
    {
        return (float) self::get('tax_rate', 16.0);
    }

    /**
     * Check if tax is enabled
     */
    public static function taxEnabled(): bool
    {
        return (bool) self::get('tax_enabled', true);
    }

    /**
     * Get receipt footer text
     */
    public static function receiptFooter(): string
    {
        return self::get('receipt_footer', 'Thank you for your business!');
    }

    /**
     * Get low stock threshold
     */
    public static function lowStockThreshold(): int
    {
        return (int) self::get('low_stock_threshold', 10);
    }

    /**
     * Initialize default settings
     */
    public static function initializeDefaults(): void
    {
        $defaults = [
            ['key' => 'system_name', 'value' => 'FeedMart POS', 'type' => 'string', 'description' => 'System Name'],
            ['key' => 'system_currency', 'value' => 'KES', 'type' => 'string', 'description' => 'Default Currency'],
            ['key' => 'system_email', 'value' => 'info@feedmart.com', 'type' => 'string', 'description' => 'System Email'],
            ['key' => 'system_phone', 'value' => '+254 700 000 000', 'type' => 'string', 'description' => 'System Phone'],
            ['key' => 'system_address', 'value' => 'Nairobi, Kenya', 'type' => 'text', 'description' => 'System Address'],
            ['key' => 'system_tagline', 'value' => 'Agriculture & Animal Feed Solutions', 'type' => 'string', 'description' => 'System Tagline'],
            ['key' => 'tax_rate', 'value' => '16.00', 'type' => 'float', 'description' => 'Default Tax Rate (%)'],
            ['key' => 'tax_enabled', 'value' => '1', 'type' => 'boolean', 'description' => 'Enable Tax'],
            ['key' => 'receipt_footer', 'value' => 'Thank you for your business!', 'type' => 'text', 'description' => 'Receipt Footer Text'],
            ['key' => 'low_stock_threshold', 'value' => '10', 'type' => 'integer', 'description' => 'Low Stock Alert Threshold'],
        ];

        foreach ($defaults as $default) {
            self::firstOrCreate(
                ['key' => $default['key']],
                $default
            );
        }
    }
}
