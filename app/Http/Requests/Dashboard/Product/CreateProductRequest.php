<?php

namespace App\Http\Requests\dashboard\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard("admin")->check();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'desc' => ['required', 'string', 'min:10', 'max:1000'],
            'colors' => ['required', 'array', 'min:1'],
            'colors.*' => ['integer', 'exists:colors,id'],
            'offer' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'images' => ['nullable', 'array'],
            'images.*' => ['array'],
            'images.*.*' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The product name is required.',
            'name.string' => 'The product name must be text.',
            'name.min' => 'The product name must be at least 3 characters long.',
            'name.max' => 'The product name may not be greater than 50 characters.',

            'price.required' => 'The product price is required.',
            'price.numeric' => 'The product price must be a number.',
            'price.min' => 'The product price must be greater than zero.',

            'category_id.required' => 'The product category is required.',
            'category_id.integer' => 'The selected category is invalid.',
            'category_id.exists' => 'The selected category does not exist.',

            'desc.required' => 'The product description is required.',
            'desc.string' => 'The product description must be text.',
            'desc.min' => 'The product description must be at least 10 characters long.',
            'desc.max' => 'The product description may not be greater than 1000 characters.',

            'colors.required' => 'At least one color must be selected for the product.',
            'colors.array' => 'The format of the selected colors is invalid.',
            'colors.min' => 'At least one color must be selected for the product.',
            'colors.*.integer' => 'One of the selected colors is invalid.',
            'colors.*.exists' => 'One of the selected colors does not exist.',

            'offer.numeric' => 'The offer value must be a number.',
            'offer.min' => 'The offer value must be at least 0.',
            'offer.max' => 'The offer value may not be greater than 100.',

            'images.array' => 'The format of the uploaded images is invalid.',
            'images.*.array' => 'The format of the uploaded images for one of the colors is invalid.',
            'images.*.*.required' => 'At least one image must be uploaded for each selected color.',
            'images.*.*.image' => 'The uploaded file must be an image.',
            'images.*.*.mimes' => 'The image format is not supported. Supported formats are: jpeg, png, jpg, gif, svg, webp.',
            'images.*.*.max' => 'The image size may not exceed 2 megabytes.',
        ];
    }
}
