<?php

namespace App\Http\Controllers\Seller;

use App\Models\Seller\Seller;
use App\Traits\defaultMessage;
use App\Models\Product\Product;
use App\Traits\defaultSaveFiles;
use App\Traits\translate;
use App\Http\Controllers\Controller;
use App\Http\Requests\productExcelRequest;
use App\Http\Requests\productRequest;
use App\Imports\productsImport;
use App\Models\Categories\ProductSubCategory;
use App\Models\Product\productImages;
use Illuminate\Support\Facades\App;
use App\Traits\checkAuthorizationSeller;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class productController extends Controller
{
    use defaultMessage,translate, defaultSaveFiles, checkAuthorizationSeller;

    public function __construct()
    {

        $this->middleware('permission:all-products', ['only' => ['index']]);

        $this->middleware('permission:edit-product', ['only' => ['update']]);

        $this->middleware('permission:create-product', ['only' => ['create']]);

        $this->middleware('permission:create-excel', ['only' => ['excel']]);

        $this->middleware('permission:delete-product', ['only' => ['destroy']]);
    }

    /**
     * Retrive Data For Creating And Update.
     *
     * @return JSON
     */

    private function retriveData($request)
    {

        // return $request;

        $data = [
            'seller_id' => $this->userID(),
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'descri' => strip_tags($request->descri),
            'price' => $request->price,
            'discount' => $request->discount,
            'count' => $request->count,
            "total" => $request->price * $request->count,
            'max_neg' => $request->m_neg,
            'tag_id' =>  $request->tag === 'null' ? null : $request->tag,
            'carousel_id' => $request->carousel === 'null' ? null : $request->carousel,
            'category_id' => $request->category === 'null' ? null : $request->category
        ];

        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function createImages($request, $id)
    {

        if ($request->hasFile('image')) {

            foreach ($request->file('image') as $image) {

                $image = $this->storeImagesProduct($image);

                productImages::create([
                    'seller_id' => $this->userID(),
                    'product_id' => $id,
                    'image_name' => $image['name'],
                    'image_path' => $image['imagePath']
                ]);
            }
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        $this->data = Seller::find($this->userID())->products;

        return $this->success();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function status($id)
    {

        Product::find($id)->toggleStatus();

        $this->message = $this->STATUS_TRANSLATE('PRODUCT');

        $this->data = [
            'status' => Product::find($id)->status
        ];

        return $this->success();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function subcategory()
    {
        $seller_category = Seller::where('id',$this->userID())->first()->category_id;

        $this->data = ProductSubCategory::where('category_id',$seller_category)->get(['id', 'name_en','name_ar']);

        return $this->success();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(productRequest $request)
    {

        $data = $this->retriveData($request);

        $response = Product::create($data);

        $this->createImages($request,$response->id);

        $this->message = $this->CREATE_TRANSLATE('PRODUCT');

        return $this->success();
    }

    /**
     * Import Product FRom Excel Sheet.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function excel(productExcelRequest $request)
    {
        // $path = $request->file('file')->get();

        // $headings = (new HeadingRowImport)->toArray('users.xlsx');


        $products = (new productsImport)->toArray($request->file('file'));

        Excel::import(new productsImport, $request->file('file'));

        $this->data = $products[0];

        $this->message = __('tables.IMPORT');

        return $this->success();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $this->data = Product::where('id', $id)->where('seller_id', $this->userID())->first();

        $imagesPhoto = [];

        $images = productImages::where('seller_id', $this->userID())->get();


        foreach ($images as $image) {

            array_push($imagesPhoto, $this->getStorageImagePath($image->image_path));
        }

        data_set($this->data, 'images', $imagesPhoto);

        return $this->success();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(productRequest $request, Product $product)
    {
        Product::where('id', $product->id)->where('seller_id', $this->userID())->update($this->retriveData($request));

        $this->createImages($request,$product->id);

        $this->message = $this->UPDATE_TRANSLATE('PRODUCT');

        $this->message = 'success update product';

        return $this->success();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function image($image)
    {
        productImages::where('seller_id', $this->userID())->where('image_name', $image)->delete();

        Storage::delete('products/' . $image);

        $this->message = $this->DELETE_IMAGE_TRANSLATE();

        return $this->success();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Product $product)
    {

        $check = Product::where('id', $product->id)->where('seller_id', $this->userID())->delete();

        if ($check) {

            $images = productImages::where('seller_id', $this->userID());

            foreach ($images->get() as $image) {

                Storage::delete($image->image_path);
            }

            productImages::where('seller_id', $this->userID())->delete();

            $this->message = $this->DELETE_TRANSLATE('PRODUCT');

            return $this->success();

        } else {

            $this->message = $this->FAILED_DELETE_TRANSLATE('PRODUCT');

            return $this->error();
        }
    }
}
