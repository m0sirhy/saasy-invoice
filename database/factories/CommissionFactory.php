<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Commission;
use Faker\Generator as Faker;

$factory->define(Commission::class, function (Faker $faker) {
    return [
        'user_id' => factory(App\User::class),
        'invoice_id' => rand(1000, 5000),
        'amount' => rand(5, 200),
        'paid_date' => now()->subDays(rand(1, 50)),
        'paid' => rand(0, 1),
        'notes' => $faker->sentence(2, false),
    ];
});
