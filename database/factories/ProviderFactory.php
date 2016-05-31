<?php

$factory->define(App\Models\Provider::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->safeEmail,
        'mobile' => $faker->optional(0.1)->phoneNumber,
        'comment' => $faker->optional(0.1)->paragraph(1),
    ];
});
