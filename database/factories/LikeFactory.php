<?php

use Faker\Generator as Faker;
use App\Like;

$factory->define(Like::class, function (Faker $faker) {

    return [
        'user_id' => Student::inRandomOrder()->first()->user_id,
        'likeable_id' => NULL,
        'likeable_type' => NULL
    ];
});
