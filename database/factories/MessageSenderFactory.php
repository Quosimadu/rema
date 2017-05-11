<?php

$factory->define(App\Models\MessageSender::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName . '' . $faker->word,
        'number' => $faker->phoneNumber,
        'provider' => $faker->word,
    ];
});
