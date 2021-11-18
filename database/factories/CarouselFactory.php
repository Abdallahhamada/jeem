<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Carousel::class, function (Faker $faker) {

    return [
        'carouselHeading' => $faker->word,
        'carouselSubHeading' => $faker->sentence,
        'carouselImage' => 'https://mdbcdn.b-cdn.net/wp-content/uploads/2017/12/carousel.jpg',
        'carouselSellerId' => App\User::where('role_id', '=', 3)->inRandomOrder()->value('id'),
        'carouselSellerStatus' => $faker->randomElement(['active', 'deactivated']),
        'carouselAdminStatus' => 'disapproved',
        'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
    ];
});
