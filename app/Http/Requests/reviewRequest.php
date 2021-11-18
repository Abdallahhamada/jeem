<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class reviewRequest extends FormRequest
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
            'id' => 'required|exists:products,id',
            'review_id' => ($this->input('_method') === 'PUT') ? 'required|exists:reviews,id' : '',
            'content' => 'required|string',
            'count' => 'required|numeric|max:5'
        ];
    }
}
