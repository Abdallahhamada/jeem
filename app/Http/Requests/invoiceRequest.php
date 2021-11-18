<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class invoiceRequest extends FormRequest
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
            'name' => 'required|string|unique:invoice,name,' . (($this->input('_method') === 'PUT') ?  $this->invoice->id : ''),
            'image' => (($this->input('_method') != 'PUT') ? 'required|image|mimes:png,jpg|max:2024' : '')
        ];
    }

    public function messages(){

        return [
            'name.required' => __('invoice.name'),
            'image.required' => __('invoice.logo')
        ];
    }
}
