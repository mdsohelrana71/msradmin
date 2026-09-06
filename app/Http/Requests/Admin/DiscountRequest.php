<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DiscountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'type' => [
                'required',
                Rule::in(['percentage', 'fixed']),
            ],
            'value' => [
                'required',
                'numeric',
                'min:0',
            ],
            'minimum_order_amount' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'maximum_discount' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'starts_at' => [
                'nullable',
                'date',
            ],
            'ends_at' => [
                'nullable',
                'date',
                'after_or_equal:starts_at',
            ],
            'priority' => [
                'nullable',
                'integer',
                'min:0',
            ],
            'allow_coupon' => [
                'nullable',
                'boolean',
            ],
            'status' => [
                'required',
                'boolean',
            ],
            'products' => [
                'nullable',
                'array',
            ],
            'products.*' => [
                'integer',
                Rule::exists('products', 'id')
                    ->where('status', true),
            ],
            'categories' => [
                'nullable',
                'array',
            ],
            'categories.*' => [
                'integer',
                Rule::exists('categories', 'id')
                    ->where('type', 'product')
                    ->where('status', true),
            ],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->input('type') === 'percentage' && (float) $this->input('value') > 100) {
                $validator->errors()->add('value', 'Percentage discount cannot be greater than 100%.');
            }
        });
    }
}