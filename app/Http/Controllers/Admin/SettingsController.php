<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\SettingsService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SettingsController extends Controller implements HasMiddleware
{
    protected SettingsService $service;

    public function __construct(SettingsService $service)
    {
        $this->service = $service;
    }

    /**
     * @return array<int, Middleware>
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:settings.view', only: ['index']),
            new Middleware('permission:settings.edit', only: ['update']),
        ];
    }

    public function index()
    {
        $names = ['site_name', 'site_email', 'site_phone', 'site_logo', 'site_favicon'];
        $defaults = [
            'site_name' => config('app.name'),
            'site_email' => '',
            'site_phone' => '',
            'site_logo' => '',
            'site_favicon' => '',
        ];

        $settings = $this->service->getSettings($names, $defaults);

        return view('admin.Settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email|max:255',
            'site_phone' => 'nullable|string|max:50',
            'site_logo' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'site_favicon' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,ico|max:2048',
        ]);

        $data = [
            'site_name' => $validated['site_name'],
            'site_email' => $validated['site_email'],
            'site_phone' => $validated['site_phone'] ?? '',
        ];

        if ($request->hasFile('site_logo')) {
            $data['site_logo'] = $request->file('site_logo');
        }

        if ($request->hasFile('site_favicon')) {
            $data['site_favicon'] = $request->file('site_favicon');
        }

        $this->service->saveSettings($data);

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}
