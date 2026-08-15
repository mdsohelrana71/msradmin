<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $blogId = $this->route('blog')?->id;

        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('blogs', 'slug')->ignore($blogId),
            ],

            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')
                    ->where('type', 'blog')
                    ->where('status', true),
            ],

            'excerpt' => [
                'nullable',
                'string',
                'max:500',
            ],

            'content' => [
                'required',
                'string',
            ],

            'featured_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'meta_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'meta_description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'meta_keywords' => [
                'nullable',
                'string',
                'max:500',
            ],

            'canonical_url' => [
                'nullable',
                'url',
                'max:255',
            ],

            'status' => [
                'required',
                'boolean',
            ],

            'published_at' => [
                'nullable',
                'date',
            ],

            'tags' => [
                'nullable',
                'array',
            ],

            'tags.*' => [
                'nullable',
            ],

            'is_featured' => [
                'nullable',
                'boolean',
            ],

            'allow_comments' => [
                'nullable',
                'boolean',
            ],

            'og_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ];
    }
}