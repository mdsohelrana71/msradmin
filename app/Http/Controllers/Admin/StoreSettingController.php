<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSettingRequest;
use App\Services\Admin\StoreSettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class StoreSettingController extends Controller implements HasMiddleware
{
    protected StoreSettingService $service;

    public function __construct(StoreSettingService $service)
    {
        $this->service = $service;
    }

    /**
     * @return array<int, Middleware>
     */
    public static function middleware(): array
    {
        return [
            new Middleware(
                'permission:store_settings.view',
                only: ['index']
            ),

            new Middleware(
                'permission:store_settings.edit',
                only: ['update']
            ),
        ];
    }

    public function index(): View
    {
        return view(
            'admin.Store-settings.index',
            $this->service->getSettings()
        );
    }

    public function update(
        StoreSettingRequest $request
    ): RedirectResponse {
        $this->service->update(
            $request->validated()
        );

        return redirect()
            ->route('admin.store-settings.index')
            ->with(
                'success',
                'Store settings updated successfully.'
            );
    }
}