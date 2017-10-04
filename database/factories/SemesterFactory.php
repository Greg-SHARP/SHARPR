<?php

use Faker\Generator as Faker;
use App\Semester;

$factory->define(Semester::class, function (Faker $faker) {

    //create availability array
    $status = ['full', 'closed', 'open', 'pending'];

    //set details
	$details = [

    	'secondary_img' => $faker->word . '.jpg',
		'info' => $faker->paragraph()
	];

    return [
    	'course_id' => NULL,
    	'address' => $faker->streetAddress,
    	'city' => $faker->city,
    	'state' => $faker->state,
    	'zip' => $faker->postcode,
    	'amount' => $faker->randomFloat(2, 50, 500),
    	'availability' => $faker->randomElement($status),
    	'primary_img' => $faker->word . '.jpg',
        'details' => json_encode($details)
    ];
});
