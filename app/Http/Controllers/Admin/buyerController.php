<?php

namespace App\Http\Controllers\Admin;

use App\Models\Buyer\Buyer;
use App\Traits\defaultMessage;
use App\Http\Controllers\Controller;
use App\Traits\translate;

class buyerController extends Controller
{

    /**
     * This Trait For Handling Default Messages Of Controller
     */

    use defaultMessage,translate;

    public function index()
    {
        $this->data = Buyer::all();

        return $this->success();
    }


    public function destroy(Buyer $buyer)
    {
        Buyer::find($buyer->id)->delete();

        $this->message = $this->DELETE_TRANSLATE('BUYER');

        return $this->success();
    }
}
