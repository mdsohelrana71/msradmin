<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'delivery_charge' => [
                'required',
                'numeric',
                'min:0',
            ],
            'free_delivery_amount' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'product_review_enabled' => [
                'boolean',
            ],
            'review_requires_approval' => [
                'boolean',
            ],
            'tax_enabled' => [
                'boolean',
            ],
            'tax_type' => [
                'required',
                'in:percentage,fixed',
            ],
            'tax_value' => [
                'required',
                'numeric',
                'min:0',
            ],
            'show_out_of_stock_products' => [
                'boolean',
            ],
            'price_symbol' => [
                'required',
                'string',
                Rule::in([
                    '৳',
                    '$',
                    '€',
                    '£',
                    '¥',
                    '₹',
                    '₽',
                    '₩',
                    '₺',
                    '﷼',
                ]),
            ],
        ];
    }
}