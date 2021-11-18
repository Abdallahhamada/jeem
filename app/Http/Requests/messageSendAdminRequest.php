<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class messageSendAdminRequest extends FormRequest
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
            "s_id" => "required|exists:buyers,id",
            "b_id" => "required|exists:buyers,id",
            "message" => "required|string|max:1000"
        ];
    }

    public function messages(){
        return [
            "b_id.required" => __('admin.message.buyer'),
            "b_id.required" => __('admin.message.seller'),
            "message.required" => __('seller.message')
        ];
    }
}
