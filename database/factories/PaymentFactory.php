<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Payment;
use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {
    return [
        'invoice_id' => rand(1000, 5000),
        'client_id' => factory(App\Client::class),
        'amount' => $faker->randomFloat(2, 100, 5000),
        'payment_at' => now(),
        'refunded' => rand(0, 1),
        'auth_code' => $faker->swiftBicNumber()
    ];
});
