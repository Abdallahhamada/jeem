<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\filterRequest;
use App\Models\Buyer\Wishlist;
use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Models\Product\productImages;
use App\Models\Review\Review;
use App\Models\Seller\Seller;
use Illuminate\Http\Request;
use App\Traits\defaultMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class productController extends Controller
{
    use defaultMessage;

    public function index()
    {

        $products = Product::where('status', true)->paginate(12);

        foreach ($products as $item) {

            $imagesPhoto = [];

            $item->setVisible(['id', 'title', 'images', 'price', 'rate', 'seller', 'cart','descri','discount','count']);

            $item->seller->setVisible(['name']);

            $rating = Review::where('product_id', $item->id,)->distinct()->get()->avg('rating');

            $images = productImages::where('product_id', $item->id)->get();

            foreach ($images as $image) {

                array_push($imagesPhoto, $this->getStorageImagePath($image->image_path));
            }

            data_set($item,  'rate', $rating);

            data_set($item, 'images', $imagesPhoto);

            if (Auth::guard('buyer')->check()) {

                $buyer_id = Auth::guard('buyer')->id();

                $order = Order::where('buyer_id', $buyer_id)->where('product_id', $item->id)->where('status', 2)->first();

                if ($order && $order->exists()) {

                    data_set($item,  'cart', $order->status);
                }
            }
        }

        $this->data = $products;

        return $this->success();
    }

    public function bestSellers()
    {

        $response = Review::select('product_id as id')->where('rating', '>=', ('3.5' || '4' || '4.5'))->distinct()->inRandomOrder(9)->get();

        foreach ($response as $id) {

            $imagesPhoto = [];

            $product = Product::find($id->id)->setVisible(['id', 'title', 'images', 'price', 'rate', 'seller', 'cart']);

            $product->seller->setVisible(['name']);

            $rating = Review::where('product_id', $id->id,)->distinct()->get()->avg('rating');

            $images = productImages::where('product_id', $id->id)->get();

            foreach ($images as $image) {

                array_push($imagesPhoto, $this->getStorageImagePath($image->image_path));
            }

            data_set($product, 'rate', $rating);

            data_set($product, 'images', $imagesPhoto);

            if (Auth::guard('buyer')->check()) {

                $buyer_id = Auth::guard('buyer')->id();

                $order = Order::where('buyer_id', $buyer_id)->where('product_id', $product->id)->where('status', 2)->first();

                if ($order && $order->exists()) {

                    data_set($product,  'cart', $order->status);
                }
            }

            array_push($this->data, $product);
        }

        return $this->success();
    }

    public function realted($category_id)
    {

        $products = Product::where('status',true)->where('category_id', $category_id)->inRandomOrder(4)->get();

        foreach ($products as $item) {

            $imagesPhoto = [];

            $item->setVisible(['id', 'title', 'images', 'price', 'rate', 'seller', 'cart','discount']);

            $item->seller->setVisible(['name']);

            $rating = Review::where('product_id', $item->id,)->distinct()->get()->avg('rating');

            $images = productImages::where('product_id', $item->id)->get();

            foreach ($images as $image) {

                array_push($imagesPhoto, $this->getStorageImagePath($image->image_path));
            }

            data_set($item,  'rate', $rating);

            data_set($item, 'images', $imagesPhoto);

            if (Auth::guard('buyer')->check()) {

                $buyer_id = Auth::guard('buyer')->id();

                $order = Order::where('buyer_id', $buyer_id)->where('product_id', $item->id)->where('status', 2)->first();

                if ($order && $order->exists()) {

                    data_set($item,  'cart', true);
                }
            }
        }

        return $products;
    }

    public function show($product)
    {

        $product = Product::where('title', trim(strtolower(str_replace('-', ' ', $product))))->first();

        $imagesPhoto = [];

        $imagesMobile = [];

        if ($product) {

            $product->setVisible(['id', 'title', 'images', 'price', 'rate', 'seller', 'descri', 'reviews', 'related', 'allow_rate', 'cart', 'wishlist','count','imagesForMobile']);

            $product->seller->setVisible(['name']);

            $rating = Review::where('product_id', $product->id)->distinct()->get()->avg('rating');

            $images = productImages::where('product_id', $product->id)->get();

            foreach ($images as $image) {

                array_push($imagesMobile,$this->getStorageImagePath($image->image_path));

                $image = [
                    'original' => $this->getStorageImagePath($image->image_path),
                    "thumbnail" => $this->getStorageImagePath($image->image_path),
                    "alt" => 'Product image'
                ];

                array_push($imagesPhoto, $image);
            }

            $reviewsContent = [];

            $reviews = Review::where('product_id', $product->id)->distinct()->get();

            foreach ($reviews as $review) {

                $review->buyer->setVisible(['name', 'image']);

                $review->buyer['image'] = $this->getImagePath($review->buyer['image_path']);

                array_push($reviewsContent, $review);
            }

            if (Auth::guard('buyer')->check()) {

                $buyer_id = Auth::guard('buyer')->id();

                $order = Order::where('buyer_id', $buyer_id)->where('product_id', $product->id)->first();

                $wishlist = Wishlist::where('buyer_id', $buyer_id)->exists();

                if ($wishlist) {

                    data_set($product,  'wishlist', true);
                }

                if ($order) {

                    if($order->status === 2){

                        data_set($product,  'cart', true);

                        data_set($product,  'count', $order->counts);

                    }
                    if ($order->status === 1 && ($order->delivery_id === 11 || $order->delivery_id === 2)) {

                        data_set($product,  'allow_rate', true);
                    }
                }
            }

            data_set($product,  'rate', $rating);

            data_set($product, 'images', $imagesPhoto);

            data_set($product, 'imagesForMobile', $imagesMobile);

            data_set($product, 'reviews', $reviewsContent);

            data_set($product, 'related', $this->realted($product->category_id));

            $this->data = $product;
        }


        return $this->success();
    }

    public function filter(filterRequest $request)
    {

        $sellers = Seller::whereIn('city', $request->city)->get();

        foreach ($sellers as $seller) {

            $products = Product::whereBetween('price', $request->price)->where('seller_id',$seller->id)->where('status',true)->paginate(10);

            foreach ($products as $item) {

                $imagesPhoto = [];

                $item->setVisible(['id', 'title', 'images', 'price', 'rate', 'seller', 'cart','descri']);

                $item->seller->setVisible(['name']);

                $rating = Review::where('product_id', $item->id,)->distinct()->get()->avg('rating');

                $images = productImages::where('product_id', $item->id)->get();

                foreach ($images as $image) {

                    array_push($imagesPhoto, $this->getStorageImagePath($image->image_path));
                }

                data_set($item,  'rate', $rating);

                data_set($item, 'images', $imagesPhoto);

                if (Auth::guard('buyer')->check()) {

                    $buyer_id = Auth::guard('buyer')->id();

                    $order = Order::where('buyer_id', $buyer_id)->where('product_id', $item->id)->where('status', 2)->first();

                    if ($order && $order->exists()) {

                        data_set($item,  'cart', $order->status);
                    }
                }
            }

            $this->data = $products;

        }

        return $this->success();
    }

    public function search($search)
    {

        $products = Product::where('status',true)->where('title', 'LIKE', '%' . $search . '%')->get();

        foreach ($products as $item) {

            $imagesPhoto = [];

            $item->setVisible(['id', 'title', 'images', 'price', 'rate', 'seller']);

            $item->seller->setVisible(['name']);

            $rating = Review::where('product_id', $item->id,)->distinct()->get()->avg('rating');

            $images = productImages::where('product_id', $item->id)->get();

            foreach ($images as $image) {

                array_push($imagesPhoto, $this->getStorageImagePath($image->image_path));
            }

            data_set($item,  'rate', $rating);

            data_set($item, 'images', $imagesPhoto);

            array_push($this->data, $item);
        }

        return $this->success();
    }

    public function sort($sort)
    {
        $products = '';

        switch($sort){

            case 'all' : {

                $products = Product::where('status',true)->paginate(10);
            } break;
            case 'recent' : {

                $products = Product::orderBy('created_at','desc')->where('status',true)->paginate(10);
            }break;

            case 'hight' : {

                $products = Product::whereBetween('price',[5000,10000])->where('status',true)->paginate(10);

            }break;
            case 'low' : {

                $products = Product::whereBetween('price',[0,5000])->where('status',true)->paginate(10);
            }break;
        };

        foreach ($products as $item) {

            $imagesPhoto = [];

            $item->setVisible(['id', 'title', 'images', 'price', 'rate', 'seller', 'cart','descri']);

            $item->seller->setVisible(['name']);

            $rating = Review::where('product_id', $item->id,)->distinct()->get()->avg('rating');

            $images = productImages::where('product_id', $item->id)->get();

            foreach ($images as $image) {

                array_push($imagesPhoto, $this->getStorageImagePath($image->image_path));
            }

            data_set($item,  'rate', $rating);

            data_set($item, 'images', $imagesPhoto);

            if (Auth::guard('buyer')->check()) {

                $buyer_id = Auth::guard('buyer')->id();

                $order = Order::where('buyer_id', $buyer_id)->where('product_id', $item->id)->where('status', 2)->first();

                if ($order && $order->exists()) {

                    data_set($item,  'cart', $order->status);
                }
            }
        }


        $this->data = $products;

        return $this->success();
    }
}
