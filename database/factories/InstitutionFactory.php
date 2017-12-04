<?php

use Faker\Generator as Faker;
use App\Institution;

$factory->define(Institution::class, function (Faker $faker) {

	$details = [
		'secondary_email' => $faker->unique()->safeEmail,
		'secondary_phone' => $faker->unique()->tollFreePhoneNumber
	];

    return [
    	'user_id' => NULL,
    	'phone' => $faker->unique()->tollFreePhoneNumber,
        'details' => json_encode($details)
    ];
});
