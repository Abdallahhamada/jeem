<?php

namespace App\Http\Controllers\Admin;

use App\Traits\zoomJWT;
use App\Models\Zoom\Zoom;
use App\Traits\defaultMessage;
use App\Http\Requests\zoomRequest;
use App\Http\Controllers\Controller;
use App\Traits\checkAuthorizationSeller;
use App\Traits\translate;
use Illuminate\Support\Facades\Auth;

class meetingController extends Controller
{
    use zoomJWT, defaultMessage,translate, checkAuthorizationSeller;
    /**
     * list All Meetings
     *
     * @return Json
     */

    public function index()
    {

        $user =  Zoom::where('admin_id',Auth::id())->get();

        foreach ($user as $key => $value) {

            $zoom_id = $user[$key]->id;

            if ($user[$key]->buyer_id) {

                $buyer = Zoom::find($zoom_id)->buyer;

                $user[$key]['buyer'] = $buyer->name;
            } else if ($user[$key]->seller_id) {

                $seller = Zoom::find($zoom_id)->seller;

                $user[$key]['seller'] = $seller->name;
            }
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

        $this->data = Zoom::where('id', $meeting->id)->first();

        return $this->success();
    }

    /**
     * Create Meeting
     *
     * @return Json
     */

    public function create(zoomRequest $request, $id, $type)
    {

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
            'admin_id' => Auth::id(),
            'start_time' => $this->toUnixTimeStamp($data->start_time)
        ];

        $this->status = $response->status() === 201;

        if ($type === 'seller') {

            Zoom::create($body += [
                'seller_id' => $id
            ]);

        } else {

            Zoom::create($body += [

                'buyer_id' => $id
            ]);
        }

        $this->message = $this->CREATE_TRANSLATE('MEETING');

        return $this->success();
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

            Zoom::where('id', $meeting->id)->update($body);

            $this->message = $this->UPDATE_TRANSLATE('MEETING');

            return $this->success();
        }
    }

    /**
     * Delete Meeting
     *
     * @return Json
     */

    public function destroy(Zoom $zoom)
    {
        $response = $this->zoomDelete($zoom->zoom_id);

        $check = Zoom::find($zoom->id)->delete();

        if ($check) {

            $this->message = $this->DELETE_TRANSLATE('MEETING');

            return $this->success();
        } else {

            $this->message = $this->FAILED_DELETE_TRANSLATE('MEETING');

            return $this->error();
        }
    }
}
