<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Product;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\OrderDetail::class, function (Faker $faker) {
    $orderId = App\Order::inRandomOrder()->value('id');
    $paymentStatus = $faker->randomElement(['paid', 'unpaid']);

    return [
        'orderId' => $orderId,
        'orderProductId' => App\Product::inRandomOrder()->value('id'),
        'orderSellerId' => App\User::where('role_id', '=', 3)->inRandomOrder()->value('id'),
        'orderPrice' => $faker->randomFloat(2, 100, 900),
        'orderTax' => 0.00,
        'orderDiscount' => $faker->randomFloat(2, 10, 99),
        'orderQuantity' => rand(1,5),
        'orderShippingType' => 'home delivery',
        'orderStatus' => $paymentStatus == 'paid' ? 'delivered' : 'undelivered'
    ];
});
