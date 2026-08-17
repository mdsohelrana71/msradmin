<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'discount_type' => [
                'required',
                'in:percentage,fixed',
            ],

            'discount_value' => [
                'required',
                'numeric',
                'min:0',
            ],

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
        ];
    }
}