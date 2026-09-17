<?php

namespace App\Services\Admin;

use App\Models\Option;
use Illuminate\Support\Facades\DB;

class ThemeColorService
{
    protected array $defaults = [
        'theme_primary_color' => '#ff6600',
        'theme_secondary_color' => '#ff2200',
        'theme_light_color' => '#ffe6cc',
    ];

    public function getColors(): array
    {
        $colors = [];

        foreach ($this->defaults as $key => $default) {
            $colors[$key] = Option::where('option_name', $key)
                ->value('option_value') ?: $default;
        }

        return $colors;
    }

    public function updateColors(array $data): bool
    {
        return DB::transaction(function () use ($data) {
            foreach ($this->defaults as $key => $default) {
                $this->saveOption(
                    $key,
                    $data[$key] ?? $default
                );
            }

            return true;
        });
    }

    protected function saveOption(string $optionName, string $value): bool
    {
        $option = Option::where('option_name', $optionName)->first();

        if ($option) {
            return (bool) $option->update([
                'option_value' => $value,
            ]);
        }

        Option::create([
            'option_name' => $optionName,
            'option_value' => $value,
            'autoload' => 'yes',
        ]);

        return true;
    }
}