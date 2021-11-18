<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\UserRole;
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

$factory->define(App\User::class, function (Faker $faker) {
    $roleId = rand(2,3);
    return [        
        'role_id' => $roleId,
        'seller_category_name' => $roleId == 3 ? $faker->randomElement(['مواد البناء', 'مكاتب هندسية', 'المقاولين']) : null,
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => bcrypt('user1234'),
        'verified' => 1,
        'accountstatus' => 'active',
        'logo' => $roleId == 3 ? 'https://www.pavilionweb.com/wp-content/uploads/2017/03/man-300x300.png' : null,
        'phonenumber' => rand(9000123456, 9999999999),
    ];
});
