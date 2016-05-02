<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Listing;

class ListingsTableSeeder extends Seeder {

	public function run()
	{

		$faker = Faker::create();
		foreach(range(1, 10) as $index)
		{
			$guests = rand(1, 6);
			Listing::create([
				'id' => $index,
				'name' => $faker->firstName . ' apartment',
				'beds' => rand(1,$guests),
				'guests' => $guests,
				'address' => $faker->address,
				'checkin_time' => rand(13,18) . ':' . ( rand(0,1) == 1 ? '00' : '30'),
				'checkout_time' => rand(9,12) . ':' . ( rand(0,1) == 1 ? '00' : '30')
			]);
		}
	}

}