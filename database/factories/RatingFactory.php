<?php

use Faker\Generator as Faker;
use App\Rating;
use App\Instructor;

$factory->define(Rating::class, function (Faker $faker) {

    return [
        'course_id' => NULL,
        'user_id' => Instructor::inRandomOrder()->first()->user_id,
        'rating' => $faker->numberBetween(1, 5),
        'comment' => $faker->paragraph()
    ];
});
