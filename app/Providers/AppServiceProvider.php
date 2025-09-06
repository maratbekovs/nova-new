<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// Удаляем App\Models\SiteSetting, Illuminate\Support\Facades\Cache, Illuminate\Support\Facades\Schema
// так как getSetting() перенесена

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Глобальная функция getSetting() теперь загружается через composer.json
        // Если вы используете Str::limit в Blade, убедитесь, что он доступен
        // \Illuminate\Support\Str::macro('limit', function ($value, $limit = 100, $end = '...') {
        //     return \Illuminate\Support\Str::of($value)->limit($limit, $end);
        // });
    }
}

