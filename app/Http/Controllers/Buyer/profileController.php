<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Zoom\Zoom;
use App\Models\Buyer\Buyer;
use App\Models\Message\Message;
use App\Models\Buyer\Wishlist;
use App\Models\Invoice\Invoice;
use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Models\Product\productImages;
use App\Models\Review\Review;
use Illuminate\Support\Facades\Auth;
use App\Traits\defaultMessage;
use App\Traits\translate;

class profileController extends Controller
{
    use defaultMessage, translate;

    public function index()
    {

        $this->data= $buyer = Auth::user();

        // $buyer->setVisible(["name","email","phone","country","city","state","pincode","address","image_name","image_path"]);

        $this->data['image'] = ($buyer['image_name'] === 'avatar.png' ? $this->getImagePath($buyer['image_path']) : $this->getStorageImagePath($buyer['image_path']));

        return $this->success();
    }

    public function orders()
    {

        $orders = Order::where('buyer_id', Auth::id())->where('status', 1)->get();

        foreach ($orders as $order) {

            $imagesPhoto = [];

            $order->product->setVisible(['title', 'created_at', 'images']);

            $images = productImages::where('product_id', $order->product_id)->get();

            foreach ($images as $image) {

                array_push($imagesPhoto, $this->getStorageImagePath($image->image_path));
            }

            $order->delivery->setVisible(['id', 'name_en', 'name_ar']);

            $order->seller->setVisible(['id', 'name']);

            data_set($order, 'images', $imagesPhoto);
        }

        $this->data = $orders;

        return $this->success();
    }

    public function invoice($code)
    {

        $order = Order::where('code', $code)->first();

        $invoiceInfo = Invoice::where('seller_id', $order->seller_id)->first();

        if ($invoiceInfo) {

            $address = $order->address;

            $buyer = $order->buyer;

            $product = $order->product;

            $this->data = [
                'key' => 1,
                'name' => $buyer->name,
                'email' => $buyer->email,
                'address' => $address->address,
                'create' => $order->created_at,
                'product' => $product->title,
                'code' => $order->code,
                'count' => $order->counts,
                'price' => $order->price,
                'c_name' => $invoiceInfo->name,
                'c_image' => ($invoiceInfo->image_name === 'avatar.png' ? $this->getImagePath($invoiceInfo->image_path) : $this->getStorageImagePath($invoiceInfo->image_path)),
                'in_code' => "RT" . date('Ymd') . rand(001, 999) . 'ER'
            ];
        }

        return $this->success();
    }

    public function wishlist()
    {

        $wishlist = Wishlist::where('buyer_id', Auth::id())->get();

        $productArray = [];

        foreach ($wishlist as $item) {

            $product = $item->product;

            $imagesPhoto = [];

            $product->setVisible(['id', 'title', 'images', 'price', 'rate', 'seller', 'cart']);

            $product->seller->setVisible(['name']);

            $rating = Review::where('product_id', $product->id)->distinct()->get()->avg('rating');

            $images = productImages::where('product_id', $product->id)->get();

            foreach ($images as $image) {

                array_push($imagesPhoto, $this->getStorageImagePath($image->image_path));
            }

            $order = Order::where('buyer_id', Auth::id())->where('product_id', $product->id)->where('status', 2)->first();

            if ($order && $order->exists()) {

                data_set($product,  'cart', true);
            }

            data_set($product,  'rate', $rating);

            data_set($product, 'images', $imagesPhoto);

            array_push($productArray, $product);
        }

        $this->data = $productArray;

        return $this->success();
    }

    public function makeWishlist($product)
    {

        $product = Product::where('title', trim(strtolower(str_replace('-', ' ', $product))))->first();

        if ($product) {

            Wishlist::create([
                'product_id' => $product->id,
                'buyer_id' => Auth::id()
            ]);
        }

        $this->message = $this->CREATE_TRANSLATE('WISHLIST');

        return $this->success();
    }

    public function wishlistDelete($id)
    {

        Wishlist::where('buyer_id', Auth::id())->where('product_id', $id)->delete();

        $this->message = $this->DELETE_TRANSLATE('WISHLIST');

        return $this->success();
    }
    public function messages()
    {

        $user = Message::where('buyer_id',Auth::id())->get();

        foreach ($user as $key => $value) {

            $id = $user[$key]->id;

            $seller = Message::find($id)->seller;

            $admin = Message::find($id)->admin;

            if ($admin) {

                $user[$key]['admin'] = $admin->name;

            }else if($seller){

                $user[$key]['seller'] = $seller->name;

            }
        }

        $this->data = $user;

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
        $message = Message::where('id', $id)->first();

        if ($message) {

            $message = $message->setVisible(['message']);

            $this->data = $message;

            return $this->success();
        }
    }

    public function meeting()
    {

        $user = Zoom::where('buyer_id', Auth::id())->get();

        foreach ($user as $key => $value) {

            $zoom_id = $user[$key]->id;

            $seller = Zoom::find($zoom_id)->seller;

            $admin = Zoom::find($zoom_id)->admin;

            $product = Zoom::find($zoom_id)->product;

            if ($admin) {

                $user[$key]['admin_name'] = $admin->name;

            }else if($seller){

                $user[$key]['seller_name'] = $seller->name;
            }

            if($product){

                $user[$key]['product_name'] = $product->title;
            }
        }

        $this->data = $user;

        return $this->success();
    }
}
