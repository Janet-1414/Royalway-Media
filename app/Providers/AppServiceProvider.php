<?php

namespace App\Providers;

use App\Models\Service;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // Services dropdown - same list and order as the Services page
        View::composer('layouts.partials.navbar', function ($view) {
            $view->with('navServices', Cache::remember(Service::NAV_CACHE_KEY, now()->addHour(), function () {
                return Service::active()->ordered()->get(['title', 'slug']);
            }));
        });
    }
}
