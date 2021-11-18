<?php

namespace App\Http\Controllers\Admin\Seller;

use App\Models\Buyer\Buyer;
use App\Traits\messagePhone;
use App\Traits\defaultMessage;
use App\Models\Seller\SendMessage;
use App\Http\Controllers\Controller;
use App\Models\Admin\messageSeller;
use App\Http\Requests\messageSendSellerRequest;
use App\Traits\checkAuthorizationSeller;
use App\Models\Order\Order;
use App\Models\Seller\Seller;
use App\Traits\translate;

class messageController extends Controller
{
    use defaultMessage,translate;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $messagesGet = SendMessage::where("seller_id", $id)->get();

        foreach ($messagesGet as $key => $value) {

            $messageId = $messagesGet[$key]->id;

            $buyer = SendMessage::find($messageId)->buyer;

            $messagesGet[$key]["buyer"] = $buyer->name;
        }

        $countMessage = messageSeller::where('seller_id',$id)->first();

        if($countMessage){

            $this->data = [
                'data' => $messagesGet,
                "count" => $countMessage->count
            ];

            return $this->success();

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller,SendMessage $message)
    {
        $message = SendMessage::where('seller_id', $seller->id)->where('buyer_id',$message->buyer_id)->first();

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

    public function destroy(Seller $seller,SendMessage $message)
    {
        $check = SendMessage::find($message->id)->where('seller_id',$seller->id)->delete();

        if ($check) {

            $this->message = $this->DELETE_TRANSLATE('MESSAGE');

            return $this->success();

        } else {

            $this->message = $this->FAILED_DELETE_TRANSLATE('MESSAGE');

            return $this->error();
        }
    }
}
