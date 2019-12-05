<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->words(5, true),
        'notes' => $faker->sentence(2, false),
        'cost' => $faker->randomFloat(2, 100, 5000),
    ];
});
