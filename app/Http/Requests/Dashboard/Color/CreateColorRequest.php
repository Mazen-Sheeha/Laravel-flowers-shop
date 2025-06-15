<?php

namespace App\Http\Requests\Dashboard\Color;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateColorRequest extends FormRequest
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
            "color" => ['required', 'hex_color', 'unique:colors,color']
        ];
    }

    /**
     * @return messages
     */
    public function messages(): array
    {
        return [
            'color.required' => 'Color is required',
            'color.hex_color' => 'This is not a color',
            'color.unique' => "This color already exists"
        ];
    }
}
