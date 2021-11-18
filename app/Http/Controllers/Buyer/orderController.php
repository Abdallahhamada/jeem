<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Order\Order;
use App\Traits\defaultMessage;
use App\Models\Product\Product;
use App\Http\Requests\orderRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Buyer\Address;
use App\Models\Negotiate\Negotiate;
use Illuminate\Http\Request;
use App\Traits\translate;

class orderController extends Controller
{
    use defaultMessage,translate;

    /**
     * Show the form for cancle order.
     *
     * @return \Illuminate\Http\Response
     */

    public function cancel($code)
    {
        $check = Order::where('code', $code)->where('buyer_id', Auth::id())->update([

            'status' => false,
            'delivery_id' => 5

        ]);

        if ($check) {

            $this->message = $this->DELETE_TRANSLATE('ORDER');

            return $this->success();

        }else{

            $this->message = $this->FAILED_DELETE_TRANSLATE('ORDER');

            return $this->error();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(orderRequest $request,$product)
    {

        $code = "JOD" . date('Ymd') . rand(001, 999);

        $product = Product::where('title', trim(strtolower(str_replace('-',' ',$product))))->first();

        $check = Order::where('product_id', $product->id)->where('buyer_id', Auth::id())->where('status', 2)->count();

        if (!$check) {

            Order::create([
                'code' => $code,
                'price' => $product->price,
                'discount' => $product->discount,
                'buyer_id' => Auth::id(),
                'product_id' => $product->id,
                "counts" => $request->count ? $request->count : 1,
                'seller_id' => $product->seller_id
            ]);

            $this->message = $this->CREATE_TRANSLATE('ORDER');

            return $this->success();

        } else {

            $this->message = 'order already added';

            return $this->error();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function activeOrder(Request $request,$code){

        Order::where("code",$code)->where('buyer_id', Auth::id())->update([
            'status'=> true,
            'address_id' => $request->address,
            'delivery_id' => 7
        ]);

        $this->message = $this->CREATE_TRANSLATE('ORDER');

        return $this->success();
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function activeAllOrders(Request $request){

        Order::whereIn("code",$request->products)->where('buyer_id', Auth::id())->update([
            'status'=> true,
            'address_id' => $request->address,
            'delivery_id' => 7
        ]);

        $this->message = $this->CREATE_TRANSLATE('ORDERS');

        return $this->success();
    }
}
