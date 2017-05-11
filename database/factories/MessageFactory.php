<?php

$factory->define(App\Models\Message::class, function (Faker\Generator $faker) {
    return [
        'receiver' => $faker->phoneNumber,
        'sender' => $faker->phoneNumber,
        'content' => $faker->paragraph(2),
    ];
});
