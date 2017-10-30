<?php

use Faker\Generator as Faker;
use App\Dislike;

$factory->define(Dislike::class, function (Faker $faker) {

    return [
        'user_id' => Student::inRandomOrder()->first()->user_id,
        'dislikeable_id' => NULL,
        'dislikeable_type' => NULL
    ];
});
