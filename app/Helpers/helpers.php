<?php

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

if (!function_exists('setting')) {
    /**
     * Get a site setting value with optional default
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting(string $key, $default = null)
    {
        return SiteSetting::get($key, $default);
    }
}

if (!function_exists('setting_file_url')) {
    /**
     * Get the URL for a file setting, checking if file exists
     *
     * @param string $key
     * @param string|null $default
     * @return string|null
     */
    function setting_file_url(string $key, ?string $default = null): ?string
    {
        $value = SiteSetting::get($key);

        if ($value && Storage::disk('public')->exists($value)) {
            return asset('storage/' . $value);
        }

        return $default;
    }
}

if (!function_exists('setting_phones')) {
    /**
     * Get phones array from JSON setting
     *
     * @return array
     */
    function setting_phones(): array
    {
        $phones = SiteSetting::get('phones');
        if (!$phones) {
            return [];
        }

        $decoded = json_decode($phones, true);
        return is_array($decoded) ? $decoded : [];
    }
}

if (!function_exists('setting_stats')) {
    /**
     * Get stats array from JSON setting
     *
     * @return array
     */
    function setting_stats(): array
    {
        $stats = SiteSetting::get('homepage_stats');
        if (!$stats) {
            return [];
        }

        $decoded = json_decode($stats, true);
        return is_array($decoded) ? $decoded : [];
    }
}
