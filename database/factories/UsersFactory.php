<?php

use App\Models\User;

$factory->define(User::class, function(Faker\Generator $faker) {
    return [
        'name' => $faker->firstName . ' ' . $faker->lastName,
        'email' => $faker->email,
        'password' => \Hash::make('pass1234'),
    ];
});