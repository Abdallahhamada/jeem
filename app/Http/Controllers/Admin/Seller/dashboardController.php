<?php

namespace App\Http\Controllers\Admin\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Traits\defaultMessage;
use DB;

class dashboardController extends Controller
{
    use defaultMessage;

    public function index($id) {

        $orders = Order::where('seller_id', $id)->get();

        $productCout = Product::where('seller_id',$id)->count();

        $ordersPrice = 0;

        $orderCount = 0;

        $orderSales = 0;

        foreach ($orders as $order){

            if($order->delivery_id === 3){

                $ordersPrice += $order->price;

                $orderSales += 1;
            }

            $orderCount += 1;
        }

        $progress = 0;

        $active = 0;

        $cancel = 0;

        foreach ($orders as $value) {

            switch($value->status){

                case '2' : ($progress += 1);break;
                case '1' : ($active += 1);break;
                case '0' : (($cancel += 1));break;

            }
        }

        $array_status = [
            'progress' => $progress,
            "active" => $active,
            "cancel" => $cancel
        ];

        $product = Product::where('seller_id',$id)->where('status',1)->orderBy('id','ASC')->get();

        $productLabel = $product->pluck('title');

        $orderSumPrice = $product->pluck('id');

        $productsData = $product->pluck('price');

        $orderData = [];

        foreach($orderSumPrice as $product_id){

            $price = Order::where('seller_id',$id)->where('status',1)->orderBy('product_id','ASC')->where('product_id',$product_id)->sum('price');

            array_push($orderData,$price);
        }

        $this->data = [
            'orders' => $orderCount,
            'revenue' => $ordersPrice,
            'status' => $array_status,
            'sales' => $orderSales,
            'products' => $productCout,
            'line' => [
                'label' => $productLabel,
                'products' => $productsData,
                "orders" => $orderData
                ]
        ];

        return $this->success();
    }
}
