<?php

use App\Models\Option;

if (!function_exists('get_option')) {
    function get_option(string $name, mixed $default = null): mixed
    {
        return Option::where('option_name', $name)
            ->value('option_value') ?? $default;
    }
}

if (!function_exists('update_option')) {
    function update_option(string $name, mixed $value): Option
    {
        return Option::updateOrCreate(
            ['option_name' => $name],
            ['option_value' => $value]
        );
    }
}