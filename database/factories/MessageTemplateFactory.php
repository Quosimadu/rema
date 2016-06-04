<?php

$factory->define(App\Models\MessageTemplate::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->words(3,true),
        'content' => $faker->paragraph(10),
        'comment' => $faker->optional()->paragraph(4),
    ];
});
