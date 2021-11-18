<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Order\Order;
use Illuminate\Http\Request;
use App\Traits\defaultMessage;
use App\Http\Requests\countRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Buyer\Wishlist;
use App\Models\Invoice\Invoice;
use App\Models\Product\Product;
use App\Models\Product\productImages;
use App\Traits\translate;

class cartController extends Controller
{
    use defaultMessage,translate;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $allOrders = ["orders" => [], "totalPrice" => 0];
        
        $order = Order::where('buyer_id', Auth::id())->where('status', 2)->get();

        $totalPrice = 0;
        
        foreach ($order as $value) {

            $imagesPhoto = [];

            $value->product->setVisible(['title','images']);

            $value->seller->setVisible(['name','created_at']);

            $images = productImages::where('product_id', $value->product_id)->get();

            foreach ($images as $image) {

                array_push($imagesPhoto, $this->getStorageImagePath($image->image_path));
            }

            $totalPrice +=  $value->price;
            
            data_set($value, 'images', $imagesPhoto);

            array_push($allOrders['orders'], $value);
        }
        
        $allOrders['totalPrice'] = $totalPrice;

        $this->data = $allOrders;

        return $this->success();
    }

    /**
     * Show the form for remove order.
     *
     * @return \Illuminate\Http\Response
     */

    public function destory($code)
    {

        $check = Order::where('code', $code)->where('buyer_id', Auth::id())->where('status', 2)->delete();

        if ($check) {

            $this->message = $this->DELETE_TRANSLATE('ORDER');

            return $this->success();

        }else{

            $this->message = $this->FAILED_DELETE_TRANSLATE('ORDER');

            return $this->error();
        }

    }

    /**
     * Show the form for remove order.
     *
     * @return \Illuminate\Http\Response
     */

    public function count(countRequest $request)
    {
        $order = Order::where('buyer_id', Auth::id())->where('code', $request->code);

        $product = $order->first()->product;

        if ($request->count <= $product->count) {

            $check = $order->update([
                'price' => ($request->count > 1) ? ($request->count * $product->price) : $product->price,
                'discount' => ($request->count > 1) ? ($request->count * $product->discount) : $product->discount,
                'counts' => ($request->count > 1) ? $request->count : $product->count
            ]);

            if ($check) {

                $this->message = $this->UPDATE_TRANSLATE('ORDER');

                return $this->success();
            }
        } else {

            $this->message = 'out of stock max count {'.$product->count.'}';

            return $this->error();
        }
    }
}
