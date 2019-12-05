<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Credit;
use Faker\Generator as Faker;

$factory->define(Credit::class, function (Faker $faker) {
    return [
        'client_id' => factory(App\Client::class),
        'user_id' => factory(App\User::class),
        'credit_date' => now(),
        'amount' => $faker->randomFloat(2, 100, 5000),
        'balance' => 0,
        'completed' => 0
    ];
});
