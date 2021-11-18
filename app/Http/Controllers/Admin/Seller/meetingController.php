<?php

namespace App\Http\Controllers\Admin\Seller;

use App\Traits\zoomJWT;
use App\Models\Zoom\Zoom;
use App\Traits\defaultMessage;
use App\Http\Controllers\Controller;
use App\Models\Seller\Seller;
use App\Traits\translate;

class meetingController extends Controller
{
    use zoomJWT,translate, defaultMessage;

    /**
     * list All Meetings
     *
     * @return Json
     */

    public function index($id)
    {

        $user =  Zoom::where('seller_id', $id)->get();

        foreach ($user as $key => $value) {

            $zoom_id = $user[$key]->id;

            $buyer = Zoom::find($zoom_id)->buyer;

            $product = Zoom::find($zoom_id)->product;

            $user[$key]['buyer_name'] = $buyer->name;

            $user[$key]['product_name'] = $product->title;
        }

        $this->data = $user;

        return $this->success();
    }

    /**
     * get Meeting
     *
     * @return Json
     */

    public function show(Seller $seller,Zoom $meeting)
    {

        $this->data = Zoom::where('id', $meeting->id)->where('seller_id', $seller->id)->first();

        return $this->success();
    }

    /**
     * Delete Meeting
     *
     * @return Json
     */

    public function destroy(Seller $seller,int $id)
    {
        $response = $this->zoomDelete($id);

        $check = Zoom::where('zoom_id', $id)->where('seller_id', $seller->id)->delete();

        if($check){

            $this->message = $this->DELETE_TRANSLATE('MEETING');

            return $this->success();

        } else {

            $this->message = $this->FAILED_DELETE_TRANSLATE('MEETING');

            return $this->error();
        }
    }
}
