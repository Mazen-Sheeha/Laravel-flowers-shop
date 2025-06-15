<?php

namespace App\Http\Requests\front\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard("web")->check();
    }

    public function rules(): array
    {
        return [
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'zip_code' => 'required',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}
