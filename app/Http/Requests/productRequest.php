<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class productRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:150|unique:products,title,'. (($this->input('_method') === 'PUT') ?  $this->product->id : ''),
            'subtitle' => 'required|string',
            'descri' => 'required|string',
            'price' => 'required|numeric',
            'discount' => 'required|numeric',
            'count' => 'required|numeric',
            'image' => (($this->input('_method') != 'PUT') ? 'required|array' : '') ,
            'm_neg' => 'required|numeric|max:99',
            'tag' => ($this->input('_method') != 'PUT') ?  'nullable|numeric|exists:tags,id' : '',
            'carousel' => ($this->input('_method') != 'PUT') ?  'nullable|numeric|exists:carousels,id' : '',
            'category' => ($this->input('_method') != 'PUT') ?  'nullable|numeric|exists:product_sub_categories,id' : ''
        ];
    }

    public function messages()
    {
        return [
            'title.required' => __('product.title'),
            'subtitle.required' => __('product.subtitle'),
            'descri.required' => __('product.descri'),
            'price.required' => __('product.price'),
            'discount.required' => __('product.discount'),
            'count.required' => __('product.count'),
            'image.required' => __('product.image'),
            'm_neg.required' => __('product.m_neg')
        ];
    }
}
