<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;

$factory->define(App\Tag::class, function (Faker $faker) {
    $sellerTagStatus = $faker->randomElement(['active', 'deactivated']);
    return [
        'tagName' => rand(10,90).'% off',
        'tagSellerId' => App\User::where('role_id', '=', 3)->inRandomOrder()->value('id'),
        'tagImage' => 'https://pbs.twimg.com/profile_images/861662902780018688/SFie8jER_400x400.jpg',
        'sellerTagStatus' => $sellerTagStatus,
        'adminTagStatus' => $sellerTagStatus == 'active' ? $faker->randomElement(['approved', 'disapproved']) : 'disapproved',
        'created_at' => now(),
    ];
});
