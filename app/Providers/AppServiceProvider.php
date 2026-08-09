<?php

namespace App\Providers;

use App\Http\Middleware\EnsurePermission;
use App\Models\Option;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
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

        try {
            $settings = Schema::hasTable('options')
                ? Option::getSettings($names, $defaults)
                : $defaults;
        } catch (QueryException) {
            $settings = $defaults;
        }

        View::share('settings', $settings);
    }
}
