<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Categories\Categories;
use App\Models\Categories\ProductSubCategory;
use App\Models\Categories\Subcategory;
use App\Models\Product\Product;
use App\Models\Product\productImages;
use App\Models\Review\Review;
use App\Traits\defaultMessage;

class categoryController extends Controller
{
    use defaultMessage;

    /**
     * Categories
     *
     * @return Method
     */

    public function category(){

        $categories = Categories::all();

        foreach($categories as $category){

            $category->setVisible(['id', 'name_ar','name_en','image']);

            $category['image'] = $this->getImagePath($category['image_path']);

            array_push($this->data,$category);

        }

        return $this->success();
    }

    public function subCategory($category){

        $id = Categories::where('name_en',trim(strtolower(str_replace('-',' ',$category))))->first()->id;

        $categories = Subcategory::where('category_id',$id)->get();

        foreach($categories as $category){

            $category->setVisible(['id', 'name_ar','name_en','image']);

            $category['image'] = $this->getImagePath($category['image_path']);

            array_push($this->data,$category);

        }

        return $this->success();
    }


    public function productSubCategory($category){

        $id = Subcategory::where('name_en',trim(strtolower(str_replace('-',' ',$category))))->first()->id;

        $categories = ProductSubCategory::where('category_sub_id',$id)->get();

        foreach($categories as $category){

            $category->setVisible(['id', 'name_ar','name_en','image','descri']);

            $category['image'] = $this->getImagePath($category['image_path']);

            array_push($this->data,$category);

        }

        return $this->success();
    }

    public function products($category){

        $id = ProductSubCategory::where('name_en',trim(strtolower(str_replace('-',' ',$category))))->first()->id;

        $products = Product::where('status',true)->where('category_id',$id)->get();

        foreach($products as $item){

            $imagesPhoto = [];

            $item->setVisible(['id','title','images','price','rate','seller','descri']);

            $item->seller->setVisible(['name']);

            $rating = Review::where('product_id',$item->id,)->distinct()->get()->avg('rating');

            $images = productImages::where('product_id',$item->id)->get();

            foreach($images as $image) {

                array_push($imagesPhoto,$this->getStorageImagePath($image->image_path));

            }

            data_set($item, 'rate', $rating);

            data_set($item,'images',$imagesPhoto);

        }

        $this->data = $products;

        return $this->success();
    }

}
