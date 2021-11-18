<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Buyer\Buyer;
use Illuminate\Http\Request;
use App\Traits\defaultMessage;
use App\Traits\defaultRegister;
use App\Http\Requests\loginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\buyerRegisterRequest;
use App\Http\Requests\buyerRequest;
use App\Jobs\resetPasswordJob;
use App\Models\Admin\Admin;
use App\Models\Buyer\Address;
use App\Models\Buyer\resetPassword;
use App\Models\Order\Order;
use App\Models\Post\commentPost;
use App\Models\Post\Post;
use App\Models\Product\Product;
use App\Models\Product\productImages;
use App\Models\Review\Review;
use App\Models\Seller\Seller;
use Illuminate\Support\Facades\DB;
use App\Traits\defaultSaveFiles;
use Dirape\Token\Token;
use App\Traits\translate;

class buyerController extends Controller
{

    /**
     * This Trait For Handling Default Messages Of Controller
     */

    use defaultMessage, translate, defaultSaveFiles, defaultRegister;

    /**
     * Shoe Method For Buyer
     *
     * @return Json
     */

    public function show()
    {

        $this->data = $response = Auth::user();

        $orders = Order::where('seller_id', Auth::id())->where('status', 2)->get();

        $this->data['count'] = $orders->count();

        $this->data['image'] = ($response['image_name'] === 'avatar.png' ? $this->getImagePath($response['image_path']) : $this->getStorageImagePath($response['image_path']));

        return $this->success();
    }

    public function login(loginRequest $request)
    {
        $buyer = Buyer::where('email', $request->email)->first();

        $auth = $this->defaultLogin('buyer', $request->email, $request->password);

        // return $buyer->verified;

        if ($auth && $buyer && $buyer->verified != '1') {

            $this->data = [
                'token' => $buyer->token
            ];

            $this->message = __('tables.ACCOUNT_ACTIVE');


            return response()->json([
                'status' => false,
                'message' => $this->message,
                'data' => $this->data
            ], 200);
        } else if ($token = $auth) {

            $this->message = __('tables.SUCCESS_LOGIN');

            $this->data = [
                'token' => $token,
                'token_type' => 'bearer',
                'expire' => Auth::guard('buyer')->factory()->getTTL() * 60,
                'role' => 'buyer'
            ];

            return $this->success();
        } else {

            $this->message = __('tables.INVALIED_EMAIL_PASSWORD');

            return $this->error();
        }
    }

    /**
     * LogOut Method From Buyer
     *
     * @return JSON
     */

    public function logout()
    {

        $this->defaultLogout();

        return $this->success();
    }

    /**
     * Register Method For Buyer
     *
     * @return Json
     */

    public function register(buyerRegisterRequest $request)
    {

        $this->name = $request->name;

        $this->email = $request->email;

        $this->phone = $request->phone;

        $this->password = $request->password;

        $this->defaultRegister(Buyer::class, 'buyer');

        $this->data = [
            'token' => $this->token
        ];

        return $this->success();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function activeCheck($token)
    {

        $buyer = Buyer::where('token', $token)->where('verified', false)->exists();

        if ($buyer) {

            return $this->success();
        } else {

            $this->message = 'this token not found or expired';

            return $this->error();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function renewCheck($token)
    {

        $buyer = resetPassword::where('token', $token)->exists();

        if ($buyer) {

            return $this->success();
        } else {

            $this->message = 'this token not found or expired';

            return $this->error();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function active(buyerRequest $request, $token)
    {

        Buyer::where('token', $token)->where('otp_phone', $request->phone)->update([
            'verified' => DB::raw('NOT verified'),
            'token' => null,
            'otp_phone' => null
        ]);

        $this->message = __('tables.ACCOUNT_ACTIVE_SUCCESS');

        return $this->success();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function sendAvtivePhoneAgain($token)
    {

        $seller = Seller::where('token', $token)->first();

        $this->verifyPhoneAgain(Seller::class, $seller->phone, $token);

        return $this->success();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:buyers,email|unique:password_buyer_reset,email'
        ]);

        $token = (new Token())->Unique('password_buyer_reset', 'token', 60);

        $buyer = Buyer::where('email', $request->email)->first();

        resetPasswordJob::dispatch('buyer', $token, $request->email, $buyer->name);

        // Mail::to($request->email)->send(new resetAccount($token));

        resetPassword::create([
            'email' => $request->email,
            'token' => $token
        ]);

        $this->message = __('tables.RESET_PASSWORD');

        return $this->success();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function renew(Request $request, $token)
    {
        //|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/

        $request->validate([
            'password' => 'required|string|min:8|same:confirm-password'
        ]);

        $resetPassword = resetPassword::where('token', $token);

        $email = $resetPassword->first()->email;

        Buyer::where('email', $email)->update([
            'password' => bcrypt($request->password)
        ]);

        $resetPassword->delete();

        $this->message = $this->UPDATE_TRANSLATE('PASSWORD');

        return $this->success();
    }

    public function password(Request $request)
    {

        Buyer::find(Auth::id())->update([
            'password' => bcrypt($request->password)
        ]);

        $this->message = $this->UPDATE_TRANSLATE('PASSWORD');

        return $this->success();
    }

    public function info(Request $request)
    {

        $data = [
            'country' => $request->country,
            'city'  => $request->city,
            'pincode' => $request->pincode,
            'state' => $request->state,
            'address' => $request->address
        ];

        $address = Address::where('buyer_id', Auth::id())->where('status', true);

        if ($address && $address->exists()) {

            $address->update([
                'address' => $request->address
            ]);
        } else {

            $address->create([
                'phone' => $request->phone,
                'address' => $request->address,
                'status' => true,
                'buyer_id' => Auth::id()
            ]);
        }

        Buyer::find(Auth::id())->update($data);

        if ($request->hasFile('image')) {

            $image = $this->storeFile($request, 'buyers', 'image');

            Buyer::find(Auth::id())->update([
                'image_name' => $image['name'],
                'image_path' => $image['imagePath']
            ]);

            data_set($data, 'image', $this->getStorageImagePath($image['imagePath']));
        }

        $this->message = $this->UPDATE_TRANSLATE('INFO');

        $this->data = $data;

        return $this->success();
    }


    public function seller($seller)
    {

        $seller = Seller::where('name', trim(strtolower(str_replace('-', ' ', $seller))))->first();

        $seller->setVisible(['name', 'email', 'city', 'products', 'posts', 'descri']);

        $products = Product::where('seller_id', $seller->id)->get();

        foreach ($products as $item) {

            $imagesPhoto = [];

            $item->setVisible(['id', 'title', 'images', 'price', 'rate', 'seller', 'cart']);

            $item->seller->setVisible(['name']);

            $rating = Review::where('product_id', $item->id)->distinct()->get()->avg('rating');

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

        $posts = Post::where('seller_id', $seller->id)->get();

        foreach ($posts as $post) {

            $commentCount = 0;

            $likeCount = 0;

            $comments = $post->comments;

            if (Auth::guard('buyer')->check()) {

                $buyer_id = Auth::guard('buyer')->id();

                $commentPost = commentPost::where('buyer_id', $buyer_id)->where('post_id', $post->id)->first();

                if ($commentPost && $commentPost->like) {

                    data_set($post, 'like', true);
                } else {

                    data_set($post, 'like', false);
                }
            }

            foreach ($comments as $comment) {

                if ($comment->comment) {

                    $commentCount +=  1;
                }

                if ($comment->like) {

                    $likeCount +=  1;
                }
            }

            $post->commentCount = $commentCount;

            $post->likeCount = $likeCount;
        }

        data_set($seller, 'products', $products);

        data_set($seller, 'posts', $posts);

        $this->data = $seller;

        return $this->success();
    }

    public function like(Post $post)
    {

        $buyer = commentPost::where('buyer_id', Auth::id())->where('like', true)->where('post_id',$post->id);

        if ($buyer->exists()) {

            $buyer->delete();

            $this->message = $this->DELETE_TRANSLATE('LIKE');

        } else {

            commentPost::create([
                'like' => true,
                'buyer_id' => Auth::id(),
                'post_id' => $post->id
            ]);

            $this->message = $this->CREATE_TRANSLATE('LIKE');
        }

        return $this->success();
    }

    public function comments(Post $post)
    {

        $comments = commentPost::where('post_id', $post->id)->get();

        foreach ($comments as $comment) {

            $buyer = $comment->buyer->setVisible(['name', 'image_path', 'image_name']);

            data_set($comment, 'image', ($buyer->image_name === 'avatar.png' ? $this->getImagePath($buyer->image_path) : $this->getStorageImagePath($buyer->image_path)));
        }

        $this->data = $comments;

        return $this->success();
    }

    public function makeComment(Request $request, Post $post)
    {

        commentPost::create([
            'comment' => $request->comment,
            'buyer_id' => Auth::id(),
            'post_id' => $post->id
        ]);

        $this->message = $this->CREATE_TRANSLATE('COMMENT');

        return $this->success();
    }
}
