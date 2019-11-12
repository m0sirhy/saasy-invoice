<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Setting;
use Faker\Generator as Faker;

$factory->define(Setting::class, function (Faker $faker) {
    return [
        'company' => $faker->company,
        'website' => 'http://' . $faker->domainName,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'address2' => $faker->secondaryAddress,
        'city' => $faker->city,
        'state' => $faker->stateAbbr,
        'zipcode' => $faker->postcode,
        'country' => $faker->country
    ];
});
