<?php

namespace App\Traits;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait zoomJWT
{

    private function generateZoomToken()
    {
        $key = env('ZOOM_API_KEY', '6MzJ7H5PQPqQacRTBtcWTw');

        $secret = env('ZOOM_API_SECRET', '0JMX2UDrsQ8Gj2Ud3OZ36o0m4FW3b4pPSSFv');

        $payload = [
            'iss' => $key,
            'exp' => strtotime('+1 minute'),
        ];

        return JWT::encode($payload, $secret, 'HS256');
    }

    private function retrieveZoomUrl()
    {
        return env('ZOOM_API_URL', 'https://api.zoom.us/v2/');
    }


    private function zoomRequest()
    {
        $jwt = $this->generateZoomToken();

        return Http::withHeaders([
            'authorization' => 'Bearer ' . $jwt,
            'content-type' => 'application/json',
        ]);
    }

    // public function zoomGet(int $id)
    // {
    //     $url = $this->retrieveZoomUrl();

    //     $request = $this->zoomRequest();

    //     $path = 'meetings/' . $id;

    //     $url = $this->retrieveZoomUrl() . $path;

    //     return $request->get($url, $query = []);
    // }

    public function zoomPost($request)
    {

        $body = [

            'topic' => $request->topic,

            'start_time' => (new \DateTime($request->start))->format('Y-m-d\TH:i:s'),

            'timezone' => 'Asia/Riyadh',

            'duration' => (new \DateTime($request->duration))->format('H'),

            'agenda' => $request->agenda,

            'settings' => [
                'host_video' => false,
                'participant_video' => false,
                'waiting_room' => true,
            ]
        ];

        $path = env('ZOOM_API_CREATE', 'users/me/meetings');

        $url = $this->retrieveZoomUrl() . $path;

        $request = $this->zoomRequest();

        return $request->post($url, $body);

    }

    public function zoomPatch($request,$id)
    {

        $body = [

            'topic' => $request->topic,

            'start_time' => (new \DateTime($request->start))->format('Y-m-d\TH:i:s'),

            'timezone' => 'Asia/Riyadh',

            'duration' => (new \DateTime($request->duration))->format('H'),

            'agenda' => $request->agenda
        ];

        $url = $this->retrieveZoomUrl();

        $path = 'meetings/' . $id;

        $url = $this->retrieveZoomUrl() . $path;

        $request = $this->zoomRequest();

        return $request->patch($url, $body);
    }

    public function zoomDelete(int $id)
    {
        $url = $this->retrieveZoomUrl();

        $path = 'meetings/' . $id;

        $url = $this->retrieveZoomUrl() . $path;

        $request = $this->zoomRequest();

        return $request->delete($url,$body = []);
    }


    public function toUnixTimeStamp(string $dateTime)
    {
        try {

            $timezone = 'Asia/Riyadh';

            $date = new \DateTime($dateTime, new \DateTimeZone($timezone));

            return $date->format('Y-m-d H:i:s');

        } catch (\Exception $e) {

            Log::error('ZoomJWT->toUnixTimeStamp : ' . $e->getMessage());

            return false;
        }
    }
}
