<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Carousel\Carousel;
use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Models\Product\productImages;
use App\Models\Review\Review;
use Illuminate\Http\Request;
use App\Traits\defaultMessage;
use Illuminate\Support\Facades\Auth;

class carouselController extends Controller
{
    use defaultMessage;

    /**
     * Slider Method From Buyer
     *
     * @return JSON
     */

    public function slider()
    {

        $response = Carousel::where('admin_status', 1)->get();

        foreach ($response as $carousel) {

            $carousel->setVisible(['title', 'subtitle', 'image']);

            $carousel['image'] = $this->getStorageImagePath($carousel['image_path']);

            array_push($this->data, $carousel);
        }

        return $this->success();
    }


    /**
     * Get Slider Products
     *
     * @return JSON
     */

    public function products($title)
    {

        $carousel = Carousel::where('title', trim(strtolower(str_replace('-', ' ', $title))))->first();

        if ($carousel && $carousel->id) {

            $products = Product::where('carousel_id', $carousel->id)->get();

            foreach ($products as $item) {

                $imagesPhoto = [];

                $item->setVisible(['id', 'title', 'images', 'price', 'rate', 'seller', 'cart']);

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
}
