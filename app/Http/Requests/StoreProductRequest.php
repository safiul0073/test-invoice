<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'group_id' => 'required|numeric|exists:groups,id',
            'variant_ids' => 'required|array',
            'variant_ids.*' => 'required|numeric|exists:variants,id',
            'price' => 'required|numeric',
            'name' => 'required|string',
            'description' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'required|image|mimes:png,jpg',
        ];
    }
}
