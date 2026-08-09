<?php

namespace App\Providers;

use App\Http\Middleware\EnsurePermission;
use App\Models\Option;
use Illuminate\Support\Facades\Route;
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
        Route::aliasMiddleware('permission', EnsurePermission::class);

        $names = ['site_name', 'site_email', 'site_phone', 'site_logo', 'site_favicon'];
        $defaults = [
            'site_name' => config('app.name'),
            'site_email' => '',
            'site_phone' => '',
            'site_logo' => '',
            'site_favicon' => '',
        ];

        $settings = Option::getSettings($names, $defaults);

        View::share('settings', $settings);
    }
}
