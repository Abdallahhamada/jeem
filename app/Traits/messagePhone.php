<?php

namespace App\Traits;

use Azima\Sms\Facades\Sms;
use App\Models\Admin\Admin;
use App\Models\Admin\messageSeller;
use Illuminate\Support\Facades\Auth;

/**
 * This Traits For Sending Message To Endpoints Api
 */
trait messagePhone
{

    /**
     * This Properity For Schema Response
     */

    private $_MESSAGE;

    /**
     * This Method For For Verify Account And Phone
     *
     * @return StatusCode
     */

    public function verifyPhone($phone, $otp)
    {
        $this->_MESSAGE =  '[Jeem] Verification code ' . $otp . '. Do not share this code with anyone';

        $response = Sms::send($this->_MESSAGE)->to([$phone])->dispatch();

        return $response['ErrorCode'];
    }

    /**
     * This Method For For Sending Message Using SMTP GateWay
     *
     * @return StatusCode
     */

    public function sendMessagePhone($message,$phone)
    {

        $this->_MESSAGE =  $message;

        $response = Sms::send($this->_MESSAGE)->to([$phone])->dispatch();

        return $response['ErrorCode'];
    }


    /**
     * This Method For Update Count Seller
     *
     * @return StatusCode
     */

     public function updateCountSeller(){

        $messageSeller = messageSeller::where('seller_id',$this->userID())->first();

        messageSeller::where('seller_id',$this->userID())->update([

            "count" => ($messageSeller->count - 1)
        ]);
     }

     /**
     * This Method For Update Count Admin
     *
     * @return StatusCode
     */

    public function updateCountAdmin(){

        $messageAdmin = Admin::first();

        Admin::first()->update([

            "count" => ($messageAdmin->count - 1)
        ]);
     }

     /**
     * This Method For Update Remider Admin
     *
     * @return StatusCode
     */

    public function updateReminderAdmin(){

        $messageAdmin = Admin::first();

        Admin::first()->update([

            "reminder" => ($messageAdmin->reminder - 1)
        ]);
     }
}
