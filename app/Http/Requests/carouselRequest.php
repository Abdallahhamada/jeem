<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class carouselRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:60|unique:carousels,title,'. (($this->input('_method') === 'PUT') ?  $this->carousel->id : ''),
            'subtitle' => 'required|string',
            'image' => (($this->input('_method') != 'PUT') ? 'required|image|mimes:png,jpg|max:2024' : '') ,
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('product.title'),
            'subtitle.required' => __('product.subtitle'),
            'image.required' => __('product.image')
        ];
    }
}
