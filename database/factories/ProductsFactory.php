<?php

use App\Models\Product;

$factory->define(Product::class, function(Faker\Generator $faker) {
    return [
        'name' => $faker->paragraph(1),
        'price' => $faker->randomDigitNotNull,
        'description' => $faker->text,
    ];
});