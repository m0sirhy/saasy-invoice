<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Subscription;
use Faker\Generator as Faker;

$factory->define(Subscription::class, function (Faker $faker) {
    return [
        'client_id' => factory(App\Client::class),
        'billing_type_id' => 1,
        'last_invoice_date' => now()->subMonth(),
        'last_invoice_id' => rand(1000, 5000),
        'next_invoice_date' => now()->addMonth(),
        'total_invoices' => 1,
        'total_billed' => rand(1000, 5000),
        'total_payed' => rand(0, 1000)
    ];
});
