<?php

use Faker\Generator as Faker;
use App\Course;
use App\Instructor;

$factory->define(Course::class, function (Faker $faker) {
    return [
    	'name' => $faker->word,
    	'instructor_id' => Instructor::inRandomOrder()->first(),
    	'address' => $faker->streetAddress,
    	'city' => $faker->city,
    	'state' => $faker->state,
    	'zip' => $faker->postcode,
    	'amount' => $faker->randomFloat(2, 50, 500),
    	'availability' => $faker->word
    ];
});
