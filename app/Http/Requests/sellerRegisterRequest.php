<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class sellerRegisterRequest extends FormRequest
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
            'name' => 'required|string|unique:sellers,name|max:40',
            'email' => 'required|email|unique:sellers,email',
            'password' => 'required|string|min:8|same:confirm-password',
            'phone' => 'required|numeric|unique:sellers,phone',
            'city' => 'required|string',
            'category'=> 'required|numeric|exists:categories,id'
            // 'g-recaptcha-response' => ['required',new ValidRecaptcha()],
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
