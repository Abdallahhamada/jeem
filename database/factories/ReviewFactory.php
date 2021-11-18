<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Product;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Review::class, function (Faker $faker) {
    $buyerId = App\User::where('role_id', '=', 2)->inRandomOrder()->value('id');
    return [
        'reviewUserId' => $buyerId,
        'reviewUserName' => App\User::where('id', '=', $buyerId)->value('name'),
        'reviewProductId' => App\Product::inRandomOrder()->value('id'),
        'reviewContent' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi pretium nunc eget interdum auctor. Vestibulum tempus justo sit amet pharetra dictum. Vestibulum nec tempus eros, id maximus erat. Sed condimentum dui non massa euismod, nec tincidunt ipsum pellentesque.',
        'rating' => rand(1.5, 5.0),
        'created_at' => now()
    ];
});
