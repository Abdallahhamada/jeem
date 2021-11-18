<?php

namespace App\Imports;

use App\Traits\defaultMessage;
use App\Models\Product\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class productsImport implements ToModel, WithHeadingRow,WithValidation
{
    use Importable;

    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {

        $userID = Auth::guard('subseller')->check() ? Auth::user()->seller_id : Auth::id();

        return new Product([
            'seller_id' => $userID,
            'title' => $row['title'],
            'subtitle' => $row['subtitle'],
            'descri' => $row['description'],
            'price' => $row['price'],
            'discount' => $row['discount'],
            'count' => $row['count'],
            'max_neg' => $row['max'],
            'image_name' => 'default.png',
            'image_path' => 'default/default.png'
        ]);
    }

    /**
     * @return array
     */

    public function rules(): array
    {
        return [
            'title' => 'required|string|min:3|max:60|unique:products,title',
            'subtitle' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'discount' => 'required|numeric',
            'count' => 'required|numeric|max:6',
            'max' => 'required|numeric|max:99',
        ];
    }

    /**
     * @return array
     */

    public function customValidationMessages()
    {
        return [
            'title.required' => __('product.title'),
            'subtitle.required' => __('product.subtitle'),
            'description.required' => __('product.descri'),
            'price.required' => __('product.price'),
            'discount.required' => __('product.discount'),
            'count.required' => __('product.count'),
            'max.required' => __('product.m_neg')
        ];
    }
}
