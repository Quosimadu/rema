<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\TimeLog;
use App\Models\Listing;

class TimeLogTableSeeder extends Seeder
{

    public function run()
    {
        $faker = Faker::create();
        $listings = Listing::all()->pluck('id')->toArray();

        for ($i = 0; $i < 16; $i++) {
            factory(TimeLog::class, 2)->create(['listing_id' => $faker->randomElement($listings)]);


        }


    }

}