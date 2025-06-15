<?php

namespace App\Http\Requests\Front\Message;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard("web")->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "message_content" => ["required", 'string', 'min:10', 'max:100']
        ];
    }

    /**
     * @return  messages[]
     */
    public function messages(): array
    {
        return [
            'message_content.required' => "The message is empty !",
            'message_content.min' => "Message must be 10 chars at least",
            'message_content.string' => "The message is in invalid format",
            'message_content.max' => "Message must be 100 chars at most"
        ];
    }
}
