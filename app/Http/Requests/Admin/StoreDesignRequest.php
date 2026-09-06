<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreDesignRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $templates = config('store_design.templates', []);
        $required = $this->route('storeDesign') === 'template';

        return [
            'design' => [
                $required ? 'required' : 'nullable',
                'string',
                'in:' . implode(',', array_keys($templates)),
            ],
        ];
    }
}