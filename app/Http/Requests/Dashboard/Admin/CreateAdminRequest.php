<?php

namespace App\Http\Requests\Dashboard\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CreateAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'min:3', 'max:20', 'string', 'unique:admins,name'],
            'email' => ['required', 'email:filter', 'regex:/@admin\.com$/', Rule::unique('users', 'email'), Rule::unique('admins', 'email')],
            'password' => ['required', 'min:6', 'confirmed'],
        ];
    }

    /**
     * @return messages
     */
    public function messages()
    {
        return [
            'name.required' => 'Admin name is required',
            'name.string' => "Admin name is not valid",
            'name.min' => "Admin name must be 3 chars at least",
            'name.max' => "Admin name must be 20 chars at most",
            "name.unique" => "This name already exists in admins",

            'email.required' => "Admin email is required",
            'email.email' => "Email is not valid",
            'email.regex' => 'Email must be in this format : admin@admin.com',
            'email.unique' => "This email already exists",

            'password.required' => 'Password is required',
            'password.min' => "Password must be 6 chars at least",
            'password.confirmed' => "Password must be confirmed"
        ];
    }
}
