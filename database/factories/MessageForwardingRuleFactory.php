<?php

$factory->define(App\Models\MessageForwardingRule::class, function (Faker\Generator $faker) {
    return [
        'incoming_destination' => $faker->phoneNumber,
        'forwarding_destination' => $faker->phoneNumber,
        'provider' => $faker->word,
    ];
});
