<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('search', [SettingsController::class, 'menuSearch'])->name('search');
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('accounts', AccountController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('categories', CategoryController::class)->except(['show']);

    Route::post('/cache/clear', function () {
        Artisan::call('optimize:clear');
        return back()->with('success', 'All cache cleared successfully.');
    })->name('cache.clear');
});
