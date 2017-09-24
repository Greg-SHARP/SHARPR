<?php

use Faker\Generator as Faker;
use App\Certificate;

$factory->define(Certificate::class, function (Faker $faker) {
    return [
        'name' => $faker->word
    ];
});
