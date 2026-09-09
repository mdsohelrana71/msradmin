<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PromoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'buttons' => ['nullable', 'array'],
            'buttons.*.id' => ['nullable', 'integer', 'exists:promo_buttons,id'],
            'buttons.*.label' => ['required', 'string', 'max:255'],
            'buttons.*.url' => ['required', 'string', 'max:2048'],
            'buttons.*.sort_order' => ['required', 'integer', 'min:0'],
            'buttons.*.status' => ['required', 'boolean'],
        ];
    }
}