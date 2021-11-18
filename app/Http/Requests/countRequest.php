<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class countRequest extends FormRequest
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
            'code' => 'required|string|exists:orders,code',
            'count' => 'required|numeric'
        ];
    }

    public function messages(){

        return [
            'code.required' => __('order.code'),
            'price.required' => __('order.price'),
            'discount.required' => __('order.discount'),
            'count.required' => __('order.count')
        ];
    }
}
