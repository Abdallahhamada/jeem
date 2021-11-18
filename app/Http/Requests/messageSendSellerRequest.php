<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class messageSendSellerRequest extends FormRequest
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
            "message" => "required|string|max:1000"
        ];
    }

    public function messages()
    {
        return [
            "b_id.required" => __('seller.message.buyer'),
            "message.required" => __('seller.message')
        ];
    }
}
