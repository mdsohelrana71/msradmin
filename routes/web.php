<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductFaqController;
use App\Http\Controllers\Admin\StoreSettingController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\ProductReviewController;
use App\Http\Controllers\Admin\ProductCompareController;
use App\Http\Controllers\Admin\ProductWishlistController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductAttributeController;
use App\Http\Controllers\Admin\ProductInventoryController;
use App\Http\Controllers\Admin\ProductAttributeValueController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('search', [SettingsController::class, 'menuSearch'])->name('search');
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('settings/theme-colors', [SettingsController::class, 'updateThemeColors'])->name('settings.theme-colors');
    Route::get('store-settings', [StoreSettingController::class, 'index'])->name('store-settings.index');
    Route::put('store-settings', [StoreSettingController::class, 'update'])->name('store-settings.update');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('accounts', AccountController::class);
    Route::resource('products', ProductController::class);
    Route::resource('product-faqs', ProductFaqController::class);
    Route::resource('product-categories', ProductCategoryController::class)
    ->parameters([
        'product-categories' => 'category',
    ]);
    Route::resource('product-attributes', ProductAttributeController::class)
    ->parameters([
        'product-attributes' => 'product_attribute',
    ]);
    Route::resource('product-attributes.values', ProductAttributeValueController::class);
    Route::resource('product-inventory', ProductInventoryController::class)->only(['index', 'show', 'edit', 'update']);
    Route::resource('product-reviews', ProductReviewController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
    Route::resource('product-wishlists', ProductWishlistController::class)->only(['index', 'show', 'destroy']);
    Route::resource('product-compares', ProductCompareController::class)->only(['index', 'show', 'destroy']);
    Route::resource('brands', BrandController::class);

    Route::resource('discounts', DiscountController::class);
    Route::patch('discounts/{discount}/toggle-status', [DiscountController::class, 'toggleStatus'])->name('discounts.toggle-status');
    Route::resource('orders', OrderController::class)->only(['index', 'show']);
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::resource('coupons', CouponController::class);
    Route::patch('coupons/{coupon}/toggle-status', [CouponController::class, 'toggleStatus'])->name('coupons.toggle-status');
    
    Route::resource('blogs', BlogController::class);
    Route::resource('blog-categories', BlogCategoryController::class)
        ->parameters([
            'blog-categories' => 'category',
        ]);

    Route::resource('customers', CustomerController::class)->only(['index', 'show', 'update']);

    Route::post('/cache/clear', function () {
        Artisan::call('optimize:clear');
        return back()->with('success', 'All cache cleared successfully.');
    })->name('cache.clear');
});
