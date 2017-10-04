<?php

use Faker\Generator as Faker;
use App\Meeting;
use App\Instructor;

$factory->define(Meeting::class, function (Faker $faker) {

	$rand = rand(0, 10);

	if($rand >= 9){

		$substitute = Instructor::inRandomOrder()->first()->id;
	}
	else{

		$substitute = NULL;
	}

    return [
        'semester_id' => NULL,
        'start' => $faker->dateTime(),
        'end' => $faker->dateTime(),
        'substitute' => $substitute
    ];
});
