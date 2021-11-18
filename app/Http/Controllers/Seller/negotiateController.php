<?php

namespace App\Http\Controllers\Seller;

use App\Traits\defaultMessage;
use App\Models\Negotiate\Negotiate;
use App\Http\Controllers\Controller;
use App\Http\Requests\negotiateSellerRequest;
use App\Models\Buyer\Address;
use App\Models\Order\Order;
use App\Traits\checkAuthorizationSeller;
use App\Models\Product\Product;
use App\Traits\translate;
use App\Traits\sendNotify;

class negotiateController extends Controller
{
    use defaultMessage, translate, sendNotify, checkAuthorizationSeller;

    public function __construct()
    {

        $this->middleware('permission:all-negotiates', ['only' => ['index']]);

        $this->middleware('permission:edit-negotatie', ['only' => ['price']]);

        $this->middleware('permission:delete-negotatie', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $order = Negotiate::where('seller_id', $this->userID())->get();

        foreach ($order as $value) {

            $value->buyer->setVisible(['name','email','phone']);

            $value->product = Product::find($value->product_id)->first()->setVisible(['title']);

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

    public function price(negotiateSellerRequest $request, Negotiate $negotiate)
    {

        Negotiate::where('id', $negotiate->id)->where('seller_id', $this->userID())->update([

            'price_seller' => $request->price

        ]);

        $this->message = $this->UPDATE_TRANSLATE('PRICE');

        $this->data = [
            'status' => false
        ];

        return $this->success();
    }

    public function accept($id)
    {

        $order = Negotiate::where('id', $id)->where('seller_id', $this->userID())->first();
        $order->product;

        $buyer = $order->buyer;

        $code = "JOD" . date('Ymd') . rand(001, 999);

        if ($order) {

            $address = Address::where('buyer_id',$order->buyer_id)->first();

            Order::create([
                'code' => $code,
                'price' => $order->price * $order->count,
                'status' => true,
                'discount' => $order->product->discount * $order->count,
                'buyer_id' => $order->buyer_id,
                'product_id' => $order->product_id,
                'address_id' => $address->id,
                "counts" => $order->count,
                'delivery_id' => 7,
                'seller_id' => $order->seller_id
            ]);

            Negotiate::where('id', $id)->where('seller_id', $this->userID())->delete();

            if ($buyer->token) {

                $this->push('hello come back', 'hello azima', ['name' => 'Mahmoud Abd Alziem'], $buyer->token);
            }

            $this->message = $this->CREATE_TRANSLATE('ORDER');
        }

        return $this->success();
    }

    public function reject($id)
    {

        $order = Negotiate::where('id', $id)->where('seller_id', $this->userID())->first();

        if ($order) {

            $buyer = $order->buyer;

            Negotiate::where('id', $id)->where('seller_id', $this->userID())->delete();

            if ($buyer->token) {

                $this->push('hello come back', 'hello azima', null, $buyer->token);
            }

            $this->message = __('tables.SUCCESS_CANCEL');
        }

        return $this->success();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Negotiate $negotiate)
    {

        Negotiate::where('id', $negotiate->id)->where('seller_id', $this->userID())->delete();

        $this->message = __('tables.SUCCESS_CANCEL');

        return $this->success();
    }
}
