<?php

namespace App\Services\Admin;

use App\Models\Option;
use Illuminate\Http\UploadedFile;
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
