<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ThemeColorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'theme_primary_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_secondary_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_light_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'theme_primary_color.regex' => 'Primary color must be a valid HEX color.',
            'theme_secondary_color.regex' => 'Secondary color must be a valid HEX color.',
            'theme_light_color.regex' => 'Light color must be a valid HEX color.',
        ];
    }
}