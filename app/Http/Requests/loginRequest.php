<?php

namespace App\Http\Requests;

use App\Rules\ValidRecaptcha;
use Illuminate\Foundation\Http\FormRequest;

class loginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|string|min:8',
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
            'email.required' => __('auth.email'),
            'password.required' => __('auth.password'),
            'g-recaptcha-response.required' => 'ReCaptcha Is Required'
        ];
    }
}
