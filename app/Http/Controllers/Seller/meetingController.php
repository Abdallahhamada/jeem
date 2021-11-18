<?php

namespace App\Http\Controllers\Seller;

use App\Traits\zoomJWT;
use App\Models\Zoom\Zoom;
use App\Traits\defaultMessage;
use App\Http\Requests\zoomRequest;
use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use App\Traits\checkAuthorizationSeller;
use App\Traits\translate;

class meetingController extends Controller
{
    use zoomJWT,translate, defaultMessage, checkAuthorizationSeller;

    public function __construct()
    {

        $this->middleware('permission:all-meetings',['only' => ['index']]);

        $this->middleware('permission:edit-meeting',['only' => ['update']]);

        $this->middleware('permission:create-meeting',['only' => ['create']]);

        $this->middleware('permission:show-meeting',['only' => ['show']]);

        $this->middleware('permission:delete-meeting',['only' => ['destroy']]);
    }

    /**
     * list All Meetings
     *
     * @return Json
     */

    public function index()
    {

        $user =  Zoom::where('seller_id', $this->userID())->get();

        foreach ($user as $key => $value) {

            $zoom_id = $user[$key]->id;

            $buyer = Zoom::find($zoom_id)->buyer;

            $admin = Zoom::find($zoom_id)->admin;

            $product = Zoom::find($zoom_id)->product;

            $user[$key]['buyer_name'] = $buyer->name;

            if($admin){
                $user[$key]['admin_name'] = $admin->name;
            }

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

    public function show(Zoom $meeting)
    {

        $this->data = Zoom::where('id', $meeting->id)->where('seller_id', $this->userID())->first();

        return $this->success();
    }

    /**
     * Create Meeting
     *
     * @return Json
     */

    public function create(zoomRequest $request)
    {

        if ($this->checkAuthorization('meeting_status', 'meeting')) {

            $order = Order::find($request->id)->first();

            $buyer_id = $order->buyer_id;

            $product_id = $order->product_id;

            $response = $this->zoomPost($request);

            $data = json_decode($response->body());

            $body = [
                'zoom_id' => $data->id,
                'topic' => $data->topic,
                'duration' => $data->duration,
                'password' => $data->password,
                'status' => $data->status,
                'start_url' => $data->start_url,
                'join_url' => $data->join_url,
                'start_time' => $this->toUnixTimeStamp($data->start_time)
            ];

            $this->status = $response->status() === 201;

            Zoom::create($body += [
                'buyer_id' => $buyer_id,
                'seller_id' => $this->userID(),
                'product_id' => $product_id
            ]);

            $this->message = $this->CREATE_TRANSLATE('MEETING');

            return $this->success();

        }else{

            $this->message = __('tables.PERMISSION');

            return $this->error();
        }
    }

    /**
     * Update Meeting
     *
     * @return Json
     */

    public function update(zoomRequest $request, Zoom $meeting)
    {

        $response = $this->zoomPatch($request, $meeting->zoom_id);

        $body = [

            'topic' => $request->topic,

            'start_time' => $this->toUnixTimeStamp($request->start),

            'duration' => (new \DateTime($request->duration))->format('H'),
        ];

        if ($response->status() == 204) {

            Zoom::where('id', $meeting->id)->where('seller_id', $this->userID())->update($body);

            $this->message = $this->UPDATE_TRANSLATE('MEETING');

            return $this->success();
        }

    }

    /**
     * Delete Meeting
     *
     * @return Json
     */

    public function destroy(int $id)
    {
        $response = $this->zoomDelete($id);

        $check = Zoom::where('zoom_id', $id)->where('seller_id', $this->userID())->delete();

        if($check){

            $this->message = $this->DELETE_TRANSLATE('MEETING');

            return $this->success();
        }
        else{

            $this->message = $this->FAILED_DELETE_TRANSLATE('MEETING');

            return $this->error();
        }
    }
}
