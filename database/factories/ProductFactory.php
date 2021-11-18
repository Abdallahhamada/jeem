<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\ProductSubCategory;
use App\Tag;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'productSubCategoryId' => App\ProductSubCategory::inRandomOrder()->value('id'),
        'productSku' => 'JBS-'.$faker->unique()->numberBetween(0001, 9999),
        'productSellerId' => App\User::where('role_id', '=', 3)->inRandomOrder()->value('id'),
        'productName' => $faker->name,
        'productPrice' => $faker->randomFloat(2, 100, 1000),
        'productDiscountedPrice' => $faker->randomFloat(2, 100, 800),
        'productDiscount' => rand(10, 90),
        'productImages' => array($faker->imageUrl($width = 200, $height = 200, 'cats'), $faker->imageUrl($width = 200, $height = 200, 'cats')),
        'productStatus' => $faker->randomElement(['active', 'deactivated']),
        'productCartDesc' => $faker->paragraph(),
        'productAddInfo' => $faker->sentence(),
        'productTechSpecs' => $faker->sentence(),
        'productThumb' => json_encode([$faker->word, $faker->word]),
        'productUpdateDate' => now(),
        'productStock' => rand(50,99),
        'productTags' => App\Tag::inRandomOrder()->value('id'),
        'productCarouselId' => App\Carousel::inRandomOrder()->value('id'),
    ];
});
