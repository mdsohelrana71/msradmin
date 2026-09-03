<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductInventoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'stock' => ['required', 'integer', 'min:0'],
            'low_stock_alert' => ['required', 'integer', 'min:0'],
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'stock.required' => 'Stock is required.',
            'stock.integer' => 'Stock must be a whole number.',
            'stock.min' => 'Stock cannot be negative.',
            'low_stock_alert.required' => 'Low stock alert is required.',
            'low_stock_alert.integer' => 'Low stock alert must be a whole number.',
            'low_stock_alert.min' => 'Low stock alert cannot be negative.',
        ];
    }
}