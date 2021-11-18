<?php

namespace App\Http\Controllers\Admin\Seller;

use App\Models\Seller\Seller;
use App\Traits\defaultMessage;
use App\Models\Product\Product;
use App\Http\Controllers\Controller;
use App\Models\Categories\ProductSubCategory;
use App\Models\Product\productImages;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use App\Traits\translate;

class productController extends Controller
{
    use defaultMessage,translate;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index($id)
    {

        $this->data = Seller::find($id)->products;

        return $this->success();
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function subcategory(){

        $this->data = ProductSubCategory::all(['id','name_' . (App::getLocale() === 'en' ? 'en' : 'ar')]);

        return $this->success();

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller,$id)
    {

        $this->data = Product::where('id', $id)->where('seller_id', $seller->id)->first();

        $imagesPhoto = [];

        $images = productImages::where('seller_id', $seller->id)->get();

        foreach ($images as $image) {

            array_push($imagesPhoto, $this->getStorageImagePath($image->image_path));
        }

        data_set($this->data, 'images', $imagesPhoto);

        return $this->success();

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Seller $seller,Product $product)
    {

        $check = Product::where('id', $product->id)->where('seller_id', $seller->id)->delete();

        if ($check) {

            Storage::delete($product->image_path);

            $this->message = $this->DELETE_TRANSLATE('PRODUCT');

            return $this->success();

        }else{

            $this->message = $this->FAILED_DELETE_TRANSLATE('PRODUCT');

            return $this->error();
        }
    }
}
