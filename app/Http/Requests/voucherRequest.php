<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class voucherRequest extends FormRequest
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
            "name" => "required|string",
            "check" => "required|string",
            "price" => "required|numeric",
            "receiver" => "required|string",
            "for" => "required|string"
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
            "check.required" => __('auth.check'),
            "price.required" => __('auth.price'),
            "receiver.required" => __('auth.receiver'),
            "for.required" => __('auth.for')
        ];
    }
}
