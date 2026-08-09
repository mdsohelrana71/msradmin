<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SettingsService
{
    public function getSettings(array $names, array $defaults = []): object
    {
        return Option::getSettings($names, $defaults);
    }

    public function saveSettings(array $data): void
    {
        foreach ($data as $key => $value) {
            if (in_array($key, ['site_logo', 'site_favicon'], true)) {
                if ($value instanceof UploadedFile) {
                    $this->saveFile($key, $value);
                }

                continue;
            }

            Option::setOption($key, $value, 'yes');
        }
    }

    public function getMenus(Request $request): array
    {
        $query = trim($request->string('q')->toString());

        if ($query === '') {
            return [];
        }

        /** @var User|null $user */
        $user = Auth::user();

        return collect(config('admin_menu'))
            ->filter(function ($item) use ($query, $user) {

                if (
                    !empty($item['permission']) &&
                    (!$user || !$user->can($item['permission']))
                ) {
                    return false;
                }

                return str_contains(
                    strtolower($item['title']),
                    strtolower($query)
                );
            })
            ->map(function ($item) {
                return [
                    'title' => $item['title'],
                    'route' => route($item['route']),
                    'icon' => $item['icon'],
                    'type' => 'menu',
                ];
            })
            ->values()
            ->all();
    }

    protected function saveFile(string $key, UploadedFile $file): void
    {
        $existing = Option::getOption($key);

        $path = $file->store('settings', 'public');

        if ($existing && Storage::disk('public')->exists($existing)) {
            Storage::disk('public')->delete($existing);
        }

        Option::setOption($key, $path, 'yes');
    }
}
