<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class postRequest extends FormRequest
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
            'content' => 'required|string|unique:posts,content,' . (($this->input('_method') === 'PUT') ?  $this->post->id : ''),
            'image' => (($this->input('_method') != 'PUT') ? 'required|image|mimes:png,jpg|max:2024' : '')
        ];
    }

    public function messages(){

        return [
            'content.required' => __('tag.title'),
            'image.required' => __('tag.image'),
        ];
    }
}
