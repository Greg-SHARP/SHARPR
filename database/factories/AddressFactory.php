<?php

use Faker\Generator as Faker;
use App\Address;

$factory->define(Address::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
    	'streetAddress' => $faker->streetAddress,
    	'city' => $faker->city,
    	'state' => $faker->state,
    	'zip' => $faker->postcode,
    	'country' => 'United States',
    	'latitude' => $faker->latitude,
    	'longitude' => $faker->longitude,
    	'addressable_id' => NULL,
    	'addressable_type' => NULL,
    	'type' => 'primary'
    ];
});
