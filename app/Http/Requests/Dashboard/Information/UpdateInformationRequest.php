<?php

namespace App\Http\Requests\dashboard\Information;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInformationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone' => ['required', 'regex:/^(\+1)?\s*\(?\d{3}\)?[-.\s]?\d{3}[-.\s]?\d{4}$/'],
            'email' => ['nullable', 'email']
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required' => "Phone is required",
            'phone.regex' => "The phone number is not a valid US format",
            'email.email' => "The email is not valid"
        ];
    }
}
