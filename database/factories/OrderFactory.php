<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Product;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Order::class, function (Faker $faker) {

    $paymentStatus = $faker->randomElement(['paid', 'unpaid']);

    return [
        'orderBuyerId' => App\User::where('role_id', '=', 2)->inRandomOrder()->value('id'),
        'orderTotalAmount' => $faker->randomFloat(2, 100, 900),
        'orderShippingAddress' => '{"email":"customer@gmail.com","name":"Buyer","address":"jeem address","address1":"jeem address1","city":"jeem city","state":"jeem state","country":"jeem country","pincode":9999}',
        'orderShippingCost' => $faker->randomFloat(2, 30, 70),
        'orderPaymentStatus' => $faker->randomElement(['paid', 'unpaid']),
        'orderPaymentType' => 'COD',
        'orderCode' => "JOD".date('Ymd').'#'.rand(100,999),
        'created_at' => now()
    ];
});
