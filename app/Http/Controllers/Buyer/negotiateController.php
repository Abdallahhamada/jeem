<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Order\Order;
use App\Traits\defaultMessage;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\negotiateRequest;
use App\Models\Buyer\Address;
use App\Models\Negotiate\Negotiate;
use App\Models\Product\Product;
use App\Traits\translate;
use App\Traits\sendNotify;

class negotiateController extends Controller
{
    use defaultMessage, translate, sendNotify;

    public function index()
    {
        $order = Negotiate::where('buyer_id', Auth::id())->get();

        foreach ($order as $value) {

            data_set($value, 'buyer', Auth::user()->name);

            $value->product = Product::find($value->product_id)->first()->setVisible(['title']);

            if ($value->price_seller === 0) {

                data_set($value, 'price_seller', 'processing');
            }
            array_push($this->data, $value);
        }

        return $this->success();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(negotiateRequest $request, $title)
    {

        $product = Product::where('title', trim(strtolower(str_replace('-', ' ', $title))))->first();

        $priceCheck = ($request->count * $product->price) * ($product->max_neg / 100);

        $count = Negotiate::where('product_id', $product->id)->where('buyer_id', Auth::id())->count();


        // return $count;

        if ($count) {

            $this->message = __('tables.NEGOTIATE_EXIST');

            return $this->success();
        } else {

            if ($request->price < $priceCheck) {

                $this->message = __('tables.PRICE_CHECK') . ' {' . $priceCheck . '}';

                return $this->success();
            }

            Negotiate::create([
                'buyer_id' => Auth::id(),
                'seller_id' => $product->seller_id,
                'product_id' => $product->id,
                'count' => $request->count,
                'price' => $request->price,
                'notes' => $request->notes ? $request->notes : null
            ]);

            $this->message = __('tables.PRICE_REQUEST');

            return $this->success();
        }
    }

    public function accept($id)
    {

        $order = Negotiate::where('id', $id)->where('buyer_id', Auth::id())->first();

        $order->product;

        $seller = $order->seller;

        $code = "JOD" . date('Ymd') . rand(001, 999);

        if ($order) {

            $address = Address::where('buyer_id', Auth::id())->first();

            Order::create([
                'code' => $code,
                'price' => $order->price_seller * $order->count,
                'status' => true,
                'discount' => $order->product->discount * $order->count,
                'buyer_id' => $order->buyer_id,
                'product_id' => $order->product_id,
                'address_id' => $address->id,
                "counts" => $order->count,
                'delivery_id' => 7,
                'seller_id' => $order->seller_id
            ]);

            Negotiate::where('id', $id)->where('buyer_id', Auth::id())->delete();

            if ($seller->token) {

                $this->push('hello come back', 'hello azima', ['name' => 'Mahmoud Abd Alziem'], $seller->token);
            }

            $this->message = $this->CREATE_TRANSLATE('ORDER');

            return $this->success();
        }
    }

    public function reject($id)
    {


        $order = Negotiate::where('id', $id)->where('buyer_id', Auth::id())->first();

        if ($order) {

            $seller = $order->seller;

            Negotiate::where('id', $id)->where('buyer_id', Auth::id())->delete();

            if ($seller->token) {

                $this->push('hello come back', 'hello azima', ['name' => 'Mahmoud Abd Alziem'], $seller->token);
            }

            $this->message = __('tables.SUCCESS_CANCEL');

            return $this->success();
        }
    }
}
