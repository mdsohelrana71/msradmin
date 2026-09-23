<?php

namespace App\Providers;

use App\Http\Middleware\EnsurePermission;
use App\Models\Option;
use App\Services\Frontend\Global\CartService;
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
            'site_address',
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
            'site_address' => '',
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

        View::composer('frontend.components.header.design-1', function ($view) {
            $cartService = app(CartService::class);

            $view->with('cartCount', $cartService->count());
        });

        View::composer('frontend.partials.cart', function ($view) {
            $cartService = app(CartService::class);
            $cart = $cartService->getCart();
            $totals = $cartService->totals();

            $view->with([
                'cartItems' => $cart?->items ?? collect(),
                'cartCount' => $cartService->count(),
                'cartTotal' => $totals['total'],
                'cartDiscount' => $totals['discount'],
                'cartSubtotal' => $totals['subtotal'],
            ]);
        });
    }
}