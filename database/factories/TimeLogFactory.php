<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Models\TimeLog::class, function (Faker $faker) {


    $startDate = Carbon::createFromTimeStamp($faker->dateTimeBetween('-60 days','+1 days')->getTimestamp());

    return [
        'user_id' => rand(1, 2),
        'listing_id' => rand(1, 2),
        'comment' => $faker->paragraph,
        'start' => $startDate->format('Y-m-d H:i:s'),
        'end' =>  $startDate->addMinutes(rand(30,180))->format('Y-m-d H:i:s'),
        'is_paid' => rand(0, 1),
    ];
});
