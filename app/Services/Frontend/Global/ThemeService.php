<?php

namespace App\Services\Frontend\Global;

use App\Models\Option;

class ThemeService
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

    public function getCssVariables(): array
    {
        $colors = $this->getColors();
        $secondary = ltrim($colors['theme_secondary_color'], '#');

        return [
            'primary' => $colors['theme_primary_color'],
            'secondary' => $colors['theme_secondary_color'],
            'light' => $colors['theme_light_color'],
            'secondary_rgb' => implode(',', [
                hexdec(substr($secondary, 0, 2)),
                hexdec(substr($secondary, 2, 2)),
                hexdec(substr($secondary, 4, 2)),
            ]),
        ];
    }
}