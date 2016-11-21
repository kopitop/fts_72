<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/


$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = config('user.password.default'),
        'remember_token' => str_random(10),
    ];
});

$factory->state(App\Models\User::class, 'admin', function ($faker) {
    return [
        'role' => config('user.role.admin'),
    ];
});
