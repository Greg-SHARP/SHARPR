<?php

use Faker\Generator as Faker;
use App\Student;

$factory->define(Student::class, function (Faker $faker) {

    //create contact array
    $status = ['none', 'email', 'phone', 'text'];

	$details = [
		
		'contact' => $faker->randomElement($status),
		'secondary_email' => $faker->unique()->safeEmail,
		'secondary_phone' => $faker->unique()->tollFreePhoneNumber
	];

    return [
    	'user_id' => NULL,
        'details' => json_encode($details)
    ];
});
