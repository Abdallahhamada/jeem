<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class manualProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name"  => "required|string|max:60",
            "tax" => "required|nullable|min:15|max:15",
            'phone' => 'required|numeric',
            "address" => "required|string",
            // "productsID" => "array",
            // "products" => "array",
            "file" => "file"
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */

    public function messages()
    {
        return [
            "name.required" => __('auth.name'),
            "tax.required" => __('auth.tax'),
            'phone.required' => __('auth.phone'),
            "address.required" => __('auth.address')
        ];
    }
}
