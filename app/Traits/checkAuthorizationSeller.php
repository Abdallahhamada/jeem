<?php

namespace App\Traits;

use App\Models\Seller\Seller;
use App\Traits\defaultMessage;
use Illuminate\Support\Facades\Auth;

trait checkAuthorizationSeller{

    use defaultMessage;

    /**
     * Check authorization of Createing [carousel,meeting,Tags]
     *
     * @return Boolean Or Error Message
     */

    private function checkAuthorization($status,$action)
    {
        $check = Seller::find($this->userID());

        if($check->$status){

            return true;

        }else{

            return false;
        }
    }

    /**
     * Retrive User ID
     *
     * @return UserID
     */

    private function userID()
    {
        return Auth::guard('subseller')->check() ? Auth::user()->seller_id : Auth::id();
    }
}
