<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductFaqRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'product_ids.*' => [
                'integer',
                'exists:products,id',
            ],

            'question' => [
                'required',
                'string',
                'max:500',
            ],

            'answer' => [
                'required',
                'string',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'status' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'product_ids.required' => 'Please select at least one product.',
            'product_ids.array' => 'Invalid product selection.',
            'product_ids.min' => 'Please select at least one product.',
            'product_ids.*.exists' => 'One or more selected products are invalid.',
        ];
    }
}