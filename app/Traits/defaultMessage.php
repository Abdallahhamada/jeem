<?php

namespace App\Traits;

/**
 * This Traits For Sending Message To Endpoints Api
 */
trait defaultMessage
{

    /**
     * This Properity For Schema Response
     */

    private $message = 'Success retrive';

    private $data = [];


    /**
     * This Method For Succcess Message
     *
     * @return ResponseJson
     */

    private function success()
    {

        return response()->json([
            'status' => true,
            'message' => $this->message,
            'data' => $this->data
        ],200);
    }

    /**
     * This Method For Error Message
     *
     * @return ResponseJson
     */

    private function error()
    {
        return response()->json([
            'status'=>false,
            'message'=>$this->message
        ],200);
    }

    /**
     * Retrive Path Of Image.
     *
     * @return PathUrl
     */

    public static function getStorageImagePath($path){

        return env('APP_ENV') === 'local' ? asset('public/storage/' . $path) : asset('storage/' . $path);
    }

    public static function getImagePath($path){

        return env('APP_ENV') === 'local' ? asset('public/' . $path) : asset($path);

    }
}
