<?php

namespace App\Providers;

use App\Models\SiteSettings;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        RateLimiter::for('dxn-leads', function (Request $request) {
            $key = 'dxn-leads:' . $request->ip();

            return [
                Limit::perMinute(5)->by($key),
                Limit::perDay(25)->by($key),
            ];
        });

        // Share site settings with all views
        View::composer('*', function ($view) {
            if (!isset($view->getData()['settings'])) {
                try {
                    $view->with('settings', SiteSettings::global());
                } catch (\Exception $e) {
                    $view->with('settings', new SiteSettings());
                }
            }
        });
    }
}
