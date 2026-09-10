<?php
namespace App\Http\Requests\Frontend;
use Illuminate\Foundation\Http\FormRequest;
class NewsletterSubscribeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/',
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'email.required' => 'Please enter your email address.',
            'email.regex' => 'Please enter a valid email address.',
        ];
    }
}