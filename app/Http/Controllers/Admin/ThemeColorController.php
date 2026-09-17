<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ThemeColorRequest;
use App\Services\Admin\ThemeColorService;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ThemeColorController extends Controller implements HasMiddleware
{
    protected ThemeColorService $service;

    public function __construct(ThemeColorService $service)
    {
        $this->service = $service;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:store-designs.view', only: ['edit']),
            new Middleware('permission:store-designs.edit', only: ['update']),
        ];
    }

    public function edit(string $themeColor)
    {
        $colors = $this->service->getColors();

        return view('admin.StoreDesign.partials.theme-colors', compact('colors'));
    }

    public function update(ThemeColorRequest $request, string $themeColor)
    {
        $this->service->updateColors($request->validated());

        return redirect()
            ->route('admin.theme-colors.edit', 'theme')
            ->with('success', 'Theme colors updated successfully.');
    }
}