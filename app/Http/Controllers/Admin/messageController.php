<?php

namespace App\Http\Controllers\Admin;

use App\Models\Buyer\Buyer;
use App\Traits\messagePhone;
use App\Traits\defaultMessage;
use App\Models\Admin\SendMessage;
use App\Http\Controllers\Controller;
use App\Models\Message\Message;
use App\Http\Requests\messageSendSellerRequest;
use App\Models\Admin\Admin;
use App\Models\Seller\Seller;
use App\Traits\translate;
use Illuminate\Support\Facades\Auth;

class messageController extends Controller
{
    use defaultMessage,translate, messagePhone;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messagesGet = Message::where('admin_id',Auth::id())->get();

        foreach ($messagesGet as $key => $value) {

            $id = $messagesGet[$key]->id;

            $buyer = Message::find($id)->buyer;

            $seller = Message::find($id)->seller;

            if ($seller) {

                $messagesGet[$key]['seller'] = $seller->name;

            }else if($buyer){

                $messagesGet[$key]['buyer'] = $buyer->name;

            }
        }

        $countMessage = Admin::first();

        if($countMessage->reminder){

            $this->data = [
                'data' => $messagesGet,
                "count" => $countMessage->reminder
            ];

            return $this->success();

        }else{

            $this->message = "Empty Messages";

            return $this->error();
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(messageSendSellerRequest $request,$id,$type)
    {

        $messageUser = '';

        if($type === 'seller'){

            $messageUser = Seller::find($id)->first();

        }else if($type == 'buyer'){

            $messageUser = Buyer::find($id)->first();
        }

        if ($messageUser) {

            $phone = $messageUser->phone;

            $message = $request->message;

            if ($this->sendMessagePhone($message, $phone) === '000') {

                $this->updateReminderAdmin();

                $this->updateCountAdmin();

                Message::create([
                    "buyer_id" => ($type === 'buyer') ? $messageUser->id : null,
                    "seller_id" => ($type === 'seller') ? $messageUser->id : null,
                    'admin_id' => Auth::id(),
                    "message" => $request->message
                ]);

                $this->message = $this->CREATE_TRANSLATE('MESSAGE');

                return $this->success();
            } else {

                $this->message = $this->FAILED_DELETE_TRANSLATE('MESSAGE');

                return $this->error();
            }
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
        }
    }
}
