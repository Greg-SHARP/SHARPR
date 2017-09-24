<?php

use Faker\Generator as Faker;
use App\User;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    static $password;

    //create status array
    $status = ['active', 'inactive', 'blocked'];

    //create details
    $details = json_encode(['bio' => $faker->text(500), 'photo' => $faker->word . '.jpg']);

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'status' => $faker->randomElement($status),
        'verified' => rand(0, 1),
        'details' => $details
    ];
});