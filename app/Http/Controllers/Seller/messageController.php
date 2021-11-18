<?php

namespace App\Http\Controllers\Seller;

use App\Models\Buyer\Buyer;
use App\Traits\messagePhone;
use App\Traits\defaultMessage;
use App\Models\Message\Message;
use App\Http\Controllers\Controller;
use App\Models\Admin\messageSeller;
use App\Http\Requests\messageSendSellerRequest;
use App\Traits\checkAuthorizationSeller;
use App\Models\Order\Order;
use App\Traits\translate;

class messageController extends Controller
{
    use defaultMessage,translate, messagePhone,checkAuthorizationSeller;

    public function __construct()
    {

        $this->middleware('permission:all-messages',['only' => ['index']]);

        $this->middleware('permission:create-message',['only' => ['create']]);

        $this->middleware('permission:show-message',['only' => ['show']]);

        $this->middleware('permission:delete-message',['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messagesGet = Message::where("seller_id", $this->userID())->get();

        foreach ($messagesGet as $key => $value) {

            $id = $messagesGet[$key]->id;

            $buyer = Message::find($id)->buyer;

            $admin = Message::find($id)->admin;

            if ($admin) {

                $messagesGet[$key]['admin'] = $admin->name;

            }else if($buyer){

                $messagesGet[$key]['buyer'] = $buyer->name;

            }
        }

        $countMessage = messageSeller::where('seller_id',$this->userID())->first();

        if($countMessage){

            $this->data = [
                'data' => $messagesGet,
                "count" => $countMessage->count
            ];

            return $this->success();

        }else{

            $this->message = __('tables.MESSAGE_OFFER');

            return $this->error();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(messageSendSellerRequest $request)
    {

        $order = Order::where('seller_id', $this->userID())->where('id',$request->id)->first();

        $countMessage = messageSeller::where('seller_id',$this->userID())->first();

        if($order && $countMessage){

            $buyer = $order->buyer;

            $phone = $buyer->phone;

            $message = $request->message;

            if ($this->sendMessagePhone($message, $phone) === '000') {

                $this->updateCountSeller();

                $this->updateCountAdmin();

                Message::create([
                    "buyer_id" => $buyer->id,
                    "seller_id" => $this->userID(),
                    "message" => $request->message
                ]);

                $this->message = $this->SEND_TRANSLATE('MESSAGE');

                return $this->success();

            } else {

                $this->message = $this->SEND_FAILED_TRANSLATE('MESSAGE');

                return $this->error();
            }
        }else{

            $this->message = __('tables.MESSAGE_OFFER');

            return $this->error();
        }

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function again(Message $message)
    {

        $orderMessage = Message::where('seller_id', $this->userID())->where('buyer_id',$message->buyer_id)->first();

        if($orderMessage){

            $buyer_id = $orderMessage->buyer_id;

            $phone = Buyer::find($buyer_id)->phone;

            if ($this->MessagePhone($message->message, $phone) === '000') {

                $this->updateCountSeller();

                $this->updateCountAdmin();

                $this->message = $this->SEND_TRANSLATE('MESSAGE');

                return $this->success();

            } else {

                $this->status = false;

                $this->message = $this->SEND_FAILED_TRANSLATE('MESSAGE');

                return $this->error();
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        $message = Message::where('seller_id', $this->userID())->where('buyer_id',$message->buyer_id)->first();

        if($message){

            $message = $message->setVisible(['message']);

            $this->data = $message;

            return $this->success();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Message $message)
    {
        $check = Message::find($message->id)->delete();

        if ($check) {

            $this->message = $this->DELETE_TRANSLATE('MESSAGE');

            return $this->success();
        }else{

            $this->message = $this->FAILED_DELETE_TRANSLATE('MESSAGE');

            return $this->error();
        }
    }
}
