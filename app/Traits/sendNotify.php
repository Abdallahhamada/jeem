<?php

namespace App\Traits;

use  LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

/**
 * This Traits For Sending notification To Endpoints Api
 */

trait sendNotify
{
    public function push($title, $body, $data, $token)
    {
        // $options

        $optionBuilder = new OptionsBuilder();

        $optionBuilder->setTimeToLive(60*20);

        /// Notification payload

        $notificationBuilder = new PayloadNotificationBuilder($title);

        $notificationBuilder->setBody($body)->setSound('default');

        /// Notification Data (optional)

        $dataBuilder = new PayloadDataBuilder();

        $dataBuilder->addData($data);

        $option = $optionBuilder->build();

        $notification = $notificationBuilder->build();

        $data = $dataBuilder->build();

        // You must change it to get your tokens
        // $tokens = MYDATABASE::pluck('fcm_token')->toArray();

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

        return $downstreamResponse->numberSuccess();
    }
}
