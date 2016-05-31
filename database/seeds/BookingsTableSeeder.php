<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Booking;
use App\Models\Listing;

class BookingsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();
		$listings = Listing::all()->pluck('id')->toArray();

		for($i=1;$i<30;$i++)
		{
			$arrival_date = $faker->dateTimeBetween('+1 days', '+1 year')->format('Y-m-d');
			$departure_date = rand(1,3) == 3 ? $faker->dateTimeBetween($arrival_date, $arrival_date.' +6 days')->format('Y-m-d') : null;
			$randomBooking = [
				'guest_name' => $faker->firstName,
				'guest_email' => $faker->optional(0.1)->email,
				'guest_phone' => $faker->optional(0.9)->phoneNumber,
				'people' => rand(1,6),
				'booking_status_id' => 1,
				'listing_id' => $faker->randomElement($listings),
				'arrival_date' => $arrival_date,
				'arrival_time' => $faker->optional(0.65)->time,
				'departure_date' => $departure_date,
				'departure_time' => $faker->optional(0.2)->time,
				'comment' => $faker->optional(0.5)->sentence(9)
			];
			Booking::create($randomBooking);
		}

	}

}