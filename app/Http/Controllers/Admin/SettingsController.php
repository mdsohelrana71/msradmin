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
        $names = [
            'site_name', 'site_email', 'site_phone', 'site_description', 'timezone',
            'site_logo', 'site_favicon',
            'mail_host', 'mail_port', 'mail_username', 'mail_password', 'mail_encryption', 'mail_from_name', 'mail_from_address',
            'email_notifications', 'login_notifications', 'system_notifications',
            'email_verification', 'two_factor_auth', 'login_activity',
            'api_base_url', 'api_key', 'api_timeout',
            'meta_title', 'meta_description', 'meta_keywords',
            'facebook_url', 'instagram_url', 'youtube_url', 'linkedin_url',
            'maintenance_mode', 'maintenance_message',
            'privacy_policy_url', 'terms_url', 'cookie_policy_url',
        ];

        $defaults = [
            'site_name' => config('app.name'),
            'site_email' => '',
            'site_phone' => '',
            'site_description' => '',
            'timezone' => config('app.timezone', 'Asia/Dhaka'),

            'site_logo' => '',
            'site_favicon' => '',

            'mail_host' => '',
            'mail_port' => 587,
            'mail_username' => '',
            'mail_password' => '',
            'mail_encryption' => 'tls',
            'mail_from_name' => config('app.name'),
            'mail_from_address' => '',

            'email_notifications' => false,
            'login_notifications' => false,
            'system_notifications' => false,

            'email_verification' => false,
            'two_factor_auth' => false,
            'login_activity' => false,

            'api_base_url' => '',
            'api_key' => '',
            'api_timeout' => 30,

            'meta_title' => '',
            'meta_description' => '',
            'meta_keywords' => '',

            'facebook_url' => '',
            'instagram_url' => '',
            'youtube_url' => '',
            'linkedin_url' => '',

            'maintenance_mode' => false,
            'maintenance_message' => '',

            'privacy_policy_url' => '',
            'terms_url' => '',
            'cookie_policy_url' => '',
        ];

        $settings = $this->service->getSettings($names, $defaults);

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            // General
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email|max:255',
            'site_phone' => 'nullable|string|max:50',
            'site_description' => 'nullable|string',
            'timezone' => 'nullable|string|max:100',

            // Appearance
            'site_logo' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'site_favicon' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,ico|max:2048',

            // Email
            'mail_host' => 'nullable|string|max:255',
            'mail_port' => 'nullable|integer|max:65535',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'nullable|in:tls,ssl',
            'mail_from_name' => 'nullable|string|max:255',
            'mail_from_address' => 'nullable|email|max:255',

            // Notifications
            'email_notifications' => 'nullable|boolean',
            'login_notifications' => 'nullable|boolean',
            'system_notifications' => 'nullable|boolean',

            // Security
            'email_verification' => 'nullable|boolean',
            'two_factor_auth' => 'nullable|boolean',
            'login_activity' => 'nullable|boolean',

            // API
            'api_base_url' => 'nullable|url|max:500',
            'api_key' => 'nullable|string|max:500',
            'api_timeout' => 'nullable|integer|min:1|max:300',

            // SEO
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',

            // Social
            'facebook_url' => 'nullable|url|max:500',
            'instagram_url' => 'nullable|url|max:500',
            'youtube_url' => 'nullable|url|max:500',
            'linkedin_url' => 'nullable|url|max:500',

            // Maintenance
            'maintenance_mode' => 'nullable|boolean',
            'maintenance_message' => 'nullable|string|max:1000',

            // Legal
            'privacy_policy_url' => 'nullable|url|max:500',
            'terms_url' => 'nullable|url|max:500',
            'cookie_policy_url' => 'nullable|url|max:500',
        ]);

        $booleanFields = [
            'email_notifications',
            'login_notifications',
            'system_notifications',
            'email_verification',
            'two_factor_auth',
            'login_activity',
            'maintenance_mode',
        ];

        foreach ($booleanFields as $field) {
            $validated[$field] = $request->boolean($field);
        }

        if ($request->hasFile('site_logo')) {
            $validated['site_logo'] = $request->file('site_logo');
        }

        if ($request->hasFile('site_favicon')) {
            $validated['site_favicon'] = $request->file('site_favicon');
        }

        $this->service->saveSettings($validated);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }

    public function menuSearch(Request $request)
    {
        $menus = $this->service->getMenus($request);
        return response()->json($menus);
    }

    public function updateThemeColors(Request $request)
    {
        $validated = $request->validate([
            'logo_header_color' => 'nullable|string|max:30',
            'topbar_color'      => 'nullable|string|max:30',
            'sidebar_color'     => 'nullable|string|max:30',
        ]);

        $this->service->saveThemeColors($validated);

        return response()->json(['success' => true]);
    }
}
