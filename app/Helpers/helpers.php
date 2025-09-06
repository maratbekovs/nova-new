<?php

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

if (! function_exists('getSetting')) {
    /**
     * Get a site setting value from the database, with caching.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function getSetting(string $key, $default = null)
    {
        // Проверяем, существует ли таблица 'site_settings'
        if (!Schema::hasTable('site_settings')) {
            return $default;
        }

        // Кэшируем настройки на 60 минут (или до очистки кэша)
        $settings = Cache::remember('site_settings', 60 * 60, function () {
            return SiteSetting::pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default;
    }
}

// Здесь можно добавить другие глобальные функции-помощники
