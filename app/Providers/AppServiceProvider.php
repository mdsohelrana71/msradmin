<?php

namespace App\Providers;

use App\Http\Middleware\EnsurePermission;
use App\Models\Option;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
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

        $names = [
            'site_name',
            'site_email',
            'site_phone',
            'site_logo',
            'site_favicon',
            'logo_header_color',
            'topbar_color',
            'sidebar_color',
            'facebook_url',
            'twitter_url',
            'instagram_url',
            'youtube_url',
            'linkedin_url',
            'price_symbol',
            'show_out_of_stock_products',
        ];

        $defaults = [
            'site_name' => config('app.name'),
            'site_email' => '',
            'site_phone' => '',
            'site_logo' => '',
            'site_favicon' => '',
            'logo_header_color' => 'dark',
            'topbar_color' => 'white',
            'sidebar_color' => 'dark',
            'facebook_url' => '',
            'twitter_url' => '',
            'instagram_url' => '',
            'youtube_url' => '',
            'linkedin_url' => '',
            'price_symbol' => '৳',
            'show_out_of_stock_products' => true,
        ];

        try {
            if (Schema::hasTable('options')) {
                $cachedSettings = Cache::remember(
                    'global_settings',
                    now()->addDay(),
                    fn () => (array) Option::getSettings($names, $defaults)
                );

                $settings = (object) $cachedSettings;
            } else {
                $settings = (object) $defaults;
            }
        } catch (QueryException) {
            $settings = (object) $defaults;
        }

        View::share('settings', $settings);
    }
}