<?php

use Faker\Generator as Faker;
use App\Student;

$factory->define(Student::class, function (Faker $faker) {

    //create contact array
    $status = ['none', 'email', 'phone', 'text'];

	$details = [
		
		'contact' => $faker->randomElement($status),
		'secondary_email' => $faker->unique()->safeEmail,
		'secondary_phone' => $faker->unique()->tollFreePhoneNumber,
        'url' => $faker->url,
        'twitter' => $faker->url,
        'facebook' => $faker->url,
        'linkedin' => $faker->url
	];

    return [
    	'user_id' => NULL,
    	'phone' => $faker->unique()->tollFreePhoneNumber,
        'details' => json_encode($details)
    ];
});
