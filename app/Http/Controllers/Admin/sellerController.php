<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\messageSeller;
use App\Models\Categories\Categories;
use App\Models\Invoice\Invoice;
use App\Models\Seller\PdfFile;
use App\Models\Seller\Seller;
use Illuminate\Http\Request;
use App\Traits\defaultMessage;
use Illuminate\Support\Facades\DB;
use App\Traits\translate;

class sellerController extends Controller
{
    use defaultMessage,translate;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data = Seller::where('verified',true)->get();

        return $this->success();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function actions(Seller $seller, $type)
    {

        Seller::find($seller->id)->update([
            $type . '_status' => DB::raw('NOT ' . $type . '_status')
        ]);

        $this->message = $this->STATUS_TRANSLATE('SELLER');

        return $this->success();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function active(Seller $seller)
    {
        Seller::find($seller->id)->update([
            'active' => DB::raw('NOT active')
        ]);

        $this->message = $this->STATUS_TRANSLATE('SELLER');

        return $this->success();
    }

    public function messageCount(Request $request, Seller $seller)
    {


        if (messageSeller::where('seller_id', $seller->id)->exists()) {

            messageSeller::where('seller_id', $seller->id)->update([
                'count' => $request->count
            ]);

        } else {

            messageSeller::create([
                'seller_id' => $seller->id,
                'count' => $request->count
            ]);
        }

        $this->message = $this->CREATE_TRANSLATE('SELLER_MESSAGES');

        return $this->success();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function file(Seller $seller)
    {

        $file = PdfFile::where('seller_id',$seller->id)->first();

        $this->data = $this->getStorageImagePath($file->path);

        $this->message = 'success download file';

        return $this->success();
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required|string|unique:sellers,name|max:40',
            'email' => 'required|email|unique:sellers,email',
            'password' => 'required|string|min:8',
            'phone' => 'required|numeric|unique:sellers,phone',
            'city' => 'required|string',
            'category'=> 'required|numeric|exists:categories,id'
        ]);

        $uniqueID = rand(5643546456547, 967484565464562);

        $user = Seller::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'unique_id' => $uniqueID,
            'verified' => 1,
            'city' => $request->city,
            'category_id' => $request->category
        ]);

        Invoice::create([
            'name' => $request->name,
            'seller_id' => $user->id
        ]);

        $user->assignRole('super-seller');

        $this->message = $this->CREATE_TRANSLATE('SELLER');

        return $this->success();
    }

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller)
    {
        $check = Seller::find($seller->id)->delete();

        if ($check) {

            $this->message = $this->DELETE_TRANSLATE('SELLER');

            return $this->success();

        }else{

            $this->message = $this->FAILED_DELETE_TRANSLATE('SELLER');

            return $this->error();
        }
    }
}
