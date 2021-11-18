<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class subsellerRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:sub_sellers,email,'. (($this->input('_method') === 'PUT') ?  $this->subseller->id : '') .'|unique:sellers,email',
            'password' => (($this->input('_method') != 'PUT') ? 'required|string|min:8' : ''),
            'permission' => 'required|array'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('subseller.name'),
            'email.required' => __('subseller.email'),
            'password.required' => __('subseller.password'),
        ];
    }
}
