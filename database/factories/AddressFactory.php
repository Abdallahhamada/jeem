<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Address::class, function (Faker $faker) {
    $userId = App\User::where('role_id', '!=',1)->pluck('id')->toArray();
    return [
        'name' => $faker->name,
        'userId' => $faker->unique()->randomElement($userId),
        'address' => $faker->address,
        'address1' => $faker->address,
        'country' => $faker->country,
        'state' => $faker->state,
        'city' => $faker->city,
        'pincode' => rand(111111, 999999),
        'isActive' => 1,
    ];
});
