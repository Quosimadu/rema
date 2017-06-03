<?php

$factory->define(App\Models\Message::class, function (Faker\Generator $faker) {
    return [
        'receiver' => $faker->phoneNumber,
        'sender' => $faker->phoneNumber,
        'content' => $faker->paragraph(2),
        'source' => $faker->word,
        'is_sent' => $faker->randomElement([0,1]),
        'is_incoming' => $faker->randomElement([0,1]),
    ];
});
