<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (!Auth::check())
            return true;
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => ['required', 'string', 'min:3', 'max:20'],
            'email' => ['required', 'email', Rule::unique('users', 'email'), Rule::unique('admins', 'email')],
            'password' => ['required', 'min:6', 'confirmed']
        ];
    }

    /**
     * 
     * @return Error Messages
     * 
     */
    public function messages(): array
    {
        return [
            'name.required' => "Username is required",
            'name.string' => "Username is invalid",
            'name.min' => "Username must be grater than 3 chars",
            'name.max' => "Username must be smaller than 20 chars",
            'email.required' => "Email is required",
            'email.email' => "Email is invalid",
            'email.unique' => "This user already exists",
            'password.required' => "Password is required",
            'password.min' => "Please write a strong password",
            'password.confirmed' => "Please write the same password in password confirmation field",
        ];
    }
}
