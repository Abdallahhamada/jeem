<?php

namespace App\Traits;

use App\Jobs\activeAccountJob;
use App\Mail\activeAccount;
use App\Traits\messagePhone;
use Illuminate\Support\Facades\Auth;
use Dirape\Token\Token;
use Illuminate\Support\Facades\Mail;

/**
 * This Traits For Sending Message To Endpoints Api
 */
trait defaultRegister
{

    use messagePhone;
    /**
     * This Properity For Schema Response
     */

    private $name;

    private $email;

    private $phone;

    private $password;

    private $uniqueID;

    private $token;

    /**
     * This Method For Default Method
     */

    public function defaultRegister($class, $type)
    {

        $otp_email = rand(458369, 427958);

        $otp_phone = rand(564357, 967482);

        $uniqueID = rand(5643546456547, 967484565464562);

        $token = (new Token())->Unique($type . 's', 'token', 60);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'phone' => $this->phone,
            'otp_phone' => $otp_phone,
            'unique_id' => $uniqueID,
            'city' => ($type === "seller" ? $this->city : null),
            'token' => $token,
            'category_id' => ($type === 'seller' ? $this->category_id : null)
        ];
        /**
         * Sending Message To Phone To Active My Phone
         *
         * @return StatusCode
         */

        //  return $token;

        //$this->verifyPhone($this->phone, $otp_phone) === '000'
        if ($this->verifyPhone($this->phone, $otp_phone) === '000') {

            $this->updateReminderAdmin();

            $this->updateCountAdmin();

            /**
             * Create Account Buyer In Database
             *
             * @return Json
             */

            $data = (($type === 'buyer') ? $data : data_set($data,'otp_email', $otp_email));

            $user = $class::create($data);

            /**
             * Array Of Data For Mail Message
             *
             * @return Array
             */

            if($type === 'seller'){

                $user->assignRole('super-seller');

                // Mail::to($this->email)->send(new activeAccount(data_set($data, 'type', $type)));

                activeAccountJob::dispatch($data,$type,$this->email);

                $this->message = __('tables.ACTIVE_ACCOUNT_SELLER');

            }else{

                $this->message = __('tables.ACTIVE_ACCOUNT_BUYER');
            }

            $this->token = $token;

            $this->status = false;

        } else {

            $this->message = __('tables.PHONE_CHECK');
        }
    }

    public function defaultLogin($guard,$email,$password){

        return Auth::guard($guard)->attempt(['email' => $email, 'password' => $password]);
    }

    public function defaultLogout()
    {
        Auth::logout();

        $this->message = __('tables.LOGOUT');

    }

    public function verifyPhoneAgain($class,$phone,$token){

        $otp_phone = rand(564357, 967482);

        if ($this->verifyPhone($phone, $otp_phone) === '000') {

            $this->updateReminderAdmin();

            $this->updateCountAdmin();

            $class::where('token',$token)->update([
                'otp_phone' => $otp_phone
            ]);

            $this->message = __('tables.ACTIVE_ACCOUNT_BUYER');
        }
    }
}
