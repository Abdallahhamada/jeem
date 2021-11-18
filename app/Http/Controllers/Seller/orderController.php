<?php

namespace App\Http\Controllers\Seller;

use App\Models\Order\Order;
use Illuminate\Http\Request;
use App\Traits\defaultMessage;
use App\Http\Controllers\Controller;
use App\Jobs\invoiceJob;
use App\Mail\invoiceMail;
use App\Models\DeliveryStatus\DeliveryStatus;
use App\Models\Invoice\Invoice;
use App\Traits\checkAuthorizationSeller;
use App\Models\Negotiate\Negotiate;
use App\Traits\translate;
use App\Traits\sendNotify;
use Illuminate\Support\Facades\Mail;

class orderController extends Controller
{
    use defaultMessage,translate,sendNotify,checkAuthorizationSeller;

    public function __construct()
    {

        $this->middleware('permission:all-orders',['only' => ['index']]);

        $this->middleware('permission:edit-order',['only' => ['update']]);

        $this->middleware('permission:delete-order',['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = Order::where('seller_id', $this->userID())->get();

        foreach ($order as $value) {

            switch($value->status){

                case '2' : $value->status = 'progress';break;
                case '1' : $value->status = 'active';break;
                case '0' : $value->status = 'cancel';break;

            }

            $value->product->setVisible(['title']);

            $value->buyer->setVisible(['name']);

            if($value->address){

                $value->address->setVisible(['address']);
            }

            $value->delivery->setVisible(['id','name_en','name_ar']);

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
            'name_ar',
            'name_en'
        ]);

        return $this->success();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Order $order)
    {
        $request->validate([
            'd_id' => 'required|exists:delivery_status,id'
        ]);

        $order = Order::where('id',$order->id)->where('seller_id', $this->userID())->first();

        if($order->status === 2){

            $this->message = 'Order Still Progress';

            return $this->error();

        }else if($order->status === 0){

            $this->message = __('tables.SUCCESS_CANCEL');

            return $this->error();

        }else{

            $invoiceInfo = Invoice::where('seller_id',$this->userID())->first();

            if($request->d_id === '2' && $invoiceInfo){

                $address = $order->address;

                $buyer = $order->buyer;

                $product = $order->product;

                $data = [
                    'name' => $buyer->name,
                    'email' => $buyer->email,
                    'address' => $address->address,
                    'create' => $order->created_at,
                    'product' => $product->title,
                    'code' => $order->code,
                    'count' => $order->counts,
                    'price' => $order->price,
                    'c_name' => $invoiceInfo->name,
                    'c_image' => $this->getStorageImagePath($invoiceInfo->image_path),
                    'in_code' => "RT" . date('Ymd') . rand(001, 999) . 'ER'
                ];

                if($invoiceInfo->name){

                    // Mail::to($this->email)->send(new invoiceMail($data));

                    invoiceJob::dispatch($buyer->email,$data);
                }

                if($buyer->token){

                    $this->push('hello come back', 'hello azima', ['name' => 'Mahmoud Abd Alziem'], $buyer->token);
                }
            }

            Order::where('id',$order->id)->where('seller_id', $this->userID())->update([

                'delivery_id' => $request->d_id
            ]);

            $this->message = $this->STATUS_TRANSLATE('ORDER');

            return $this->success();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Order $order)
    {
        $check = Order::where('seller_id',$this->userID())->where('id',$order->id)->delete();

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
