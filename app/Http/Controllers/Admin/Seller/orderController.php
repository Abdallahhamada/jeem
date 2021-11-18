<?php

namespace App\Http\Controllers\Admin\Seller;

use App\Models\Order\Order;
use Illuminate\Http\Request;
use App\Traits\defaultMessage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\DeliveryStatus\DeliveryStatus;
use App\Traits\checkAuthorizationSeller;
use App\Models\Negotiate\Negotiate;
use App\Models\Seller\Seller;
use App\Traits\translate;

class orderController extends Controller
{
    use defaultMessage,translate;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $order = Order::where('seller_id', $id)->get();

        foreach ($order as $value) {

            switch($value->status){

                case '2' : $value->status = 'progress';break;
                case '1' : $value->status = 'active';break;
                case '0' : $value->status = 'cancel';break;

            }

            $value->product->setVisible(['title']);

            $value->buyer->setVisible(['name']);

            $value->delivery->setVisible(['id','name_' . (App::getLocale() === 'en' ? 'en' : 'ar')]);

            array_push($this->data, $value->setHidden(['buyer_id','seller_id','product_id','delivery_id']));
        }

        return $this->success();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function delivery()
    {
        $this->data = DeliveryStatus::all([
            'id',
            'name_' . (App::getLocale() === 'en' ? 'en' : 'ar')
        ]);

        return $this->success();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Seller $seller,Order $order)
    {
        $check = Order::where('seller_id',$seller->id)->where('id',$order->id)->delete();

        if($check){

            Negotiate::where('code',$order->code)->delete();

            $this->message = $this->DELETE_TRANSLATE('ORDER');

            return $this->success();

        }else{

            $this->message = $this->FAILED_DELETE_TRANSLATE('ORDER');

            return $this->error();
        }
    }
}
