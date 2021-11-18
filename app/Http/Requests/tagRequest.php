<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class tagRequest extends FormRequest
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
            'title' => 'required|string|unique:tags,title,' . (($this->input('_method') === 'PUT') ?  $this->tag->id : ''),
            'image' => (($this->input('_method') != 'PUT') ? 'required|image|mimes:png,jpg|max:2024' : '')
        ];
    }

    public function messages(){
        return [
            'title.required' => __('tag.title'),
            'image.required' => __('tag.image'),
        ];
    }
}
