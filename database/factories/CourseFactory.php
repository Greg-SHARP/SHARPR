<?php

use Faker\Generator as Faker;
use App\Course;
use App\Instructor;

$factory->define(Course::class, function (Faker $faker) {
    return [
    	'instructor' => Instructor::inRandomOrder()->first()->user_id,
        'title' => $faker->word,
        'description' => $faker->paragraph()
    ];
});
