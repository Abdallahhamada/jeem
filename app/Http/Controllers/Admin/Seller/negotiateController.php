<?php

namespace App\Http\Controllers\Admin\Seller;

use App\Traits\defaultMessage;
use App\Models\Negotiate\Negotiate;
use App\Http\Controllers\Controller;
use App\Http\Requests\negotiateSellerRequest;
use App\Traits\checkAuthorizationSeller;
use App\Models\Product\Product;
use App\Models\Seller\Seller;

class negotiateController extends Controller
{
    use defaultMessage;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index($id)
    {
        $order = Negotiate::where('seller_id', $id)->get();

        foreach ($order as $value) {

            $value->buyer->setVisible(['name']);

            $id = $value->orders->setVisible(['product_id']);

            $value->product = Product::find($id)->first()->setVisible(['title']);

            array_push($this->data, $value);
        }

        return $this->success();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function price(negotiateSellerRequest $request,Negotiate $negotiate){

        Negotiate::where('id',$negotiate->id)->where('seller_id', $this->userID())->update([

            'price_seller' => $request->price

        ]);

        $this->message = 'success update price';

        return $this->success();
     }


     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Seller $seller,Negotiate $negotiate){

        Negotiate::where('id',$negotiate->id)->where('seller_id', $seller->id)->delete();

        $this->message = 'success cancel offer';

        return $this->success();
     }
}
