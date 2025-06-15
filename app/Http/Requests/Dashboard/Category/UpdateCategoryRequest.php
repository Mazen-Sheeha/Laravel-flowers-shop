<?php

namespace App\Http\Requests\Dashboard\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard("admin")->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => ['required', 'string', 'min:3', 'max:30']
        ];
    }

    /**
     * 
     * @return messages
     */
    public function messages(): array
    {
        return [
            'name.string' => "Category name is not valid",
            'name.required' => "Category name is required",
            'name.min' => "Category name must be 3 chars at least",
            'name.max' => "Category name must be 30 chars at most"
        ];
    }
}
