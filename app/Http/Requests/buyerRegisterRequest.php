<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class buyerRegisterRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email|unique:buyers,email',
            'password' => 'required|string|min:8|same:confirm-password',
            'phone' => 'required|numeric|unique:sellers,phone|unique:buyers,phone'
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
            'name.required' => __('auth.name'),
            'email.required' => __('auth.email'),
            'password.required' => __('auth.password'),
            'phone.required' => __('auth.phone'),
            'g-recaptcha-response.required' => 'ReCaptcha Is Required'
        ];
    }
}
