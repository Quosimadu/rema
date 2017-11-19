<?php

$factory->define(App\Models\Listing::class, function (Faker\Generator $faker) {
    $guests = rand(1, 6);
    return [
        'name' => $faker->firstName . ' apartment',
        'beds' => rand(1,$guests),
        'guests' => $guests,
        'address' => $faker->address,
        'check_in_time' => rand(13,18) . ':' . ( rand(0,1) == 1 ? '00' : '30'),
        'check_out_time' => rand(9,12) . ':' . ( rand(0,1) == 1 ? '00' : '30'),
        'is_active' => rand(0,1),
    ];
});
