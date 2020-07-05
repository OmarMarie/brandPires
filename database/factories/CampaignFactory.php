<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Campaign;
use Faker\Generator as Faker;

$factory->define(Campaign::class, function (Faker $faker) {
    return [
        'name' => $faker->word(),
        'lat' => '31.919036',
        'lng' => '35.919128',
        'mark_pts' => $faker->numberBetween(400, 1000),
        'from_time' => '8:00:00',
        'to_time' => '13:00:00',
        'date' => $faker->dateTimeBetween('now', '+1 years'),
        'speed' => $faker->numberBetween(1, 15),
        'brand_id' => $faker->numberBetween(1, 7),
        'employee_id' => $faker->numberBetween(1, 7),
        'bulk_id' => $faker->numberBetween(1, 7),

    ];
});
