<?php

namespace App\Http\Requests\Dashboard\ZipCode;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ZipCodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard("admin")->check();
    }

    public function rules(): array
    {
        $rules = [
            "shipping_price" => ['required', 'numeric', 'gt:0', 'lt:1000']
        ];

        if ($this->isMethod('post')) {
            $rules['zip_code'] = ['required', 'unique:zip_codes,zip_code'];
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['zip_code'] = [
                'required',
                Rule::unique('zip_codes', 'zip_code')->ignore($this->route('zip_code'))
            ];
        }

        return $rules;
    }

    public function messages(): array
    {
        return ['zip_code.unique' => "This ZIP code already exists"];
    }
}
