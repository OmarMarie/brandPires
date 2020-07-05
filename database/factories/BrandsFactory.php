<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Brand;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Brand::class, function (Faker $faker) {
    return [
        'brand_name' => $faker->word,
        'total_bubbles_number' => $faker->numberBetween(1000, 7000),
        'total_gifts_number' => $faker->numberBetween(100, 300),
        'total_price' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 10, $max = 100),
        'status' => $faker->numberBetween(0,1),
        'img' => $faker->randomElement($array = array ('1','2','3', '4', '5', '6', '7', '8', '9', '10')).'.jpg',
    ];
});
