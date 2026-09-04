<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $review = $this->route('productReview');

        return [
            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
            ],
            'user_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],
            'rating' => [
                'required',
                'integer',
                'min:1',
                'max:5',
            ],
            'title' => [
                'nullable',
                'string',
                'max:255',
            ],
            'review' => [
                'nullable',
                'string',
            ],
            'is_verified' => [
                'boolean',
            ],
            'status' => [
                'required',
                'boolean',
            ],
            'images' => [
                'nullable',
                'array',
            ],
            'images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
            'removed_image_ids' => [
                'nullable',
                'array',
            ],
            'removed_image_ids.*' => [
                'integer',
                Rule::exists('product_review_images', 'id'),
            ],
        ];
    }
}