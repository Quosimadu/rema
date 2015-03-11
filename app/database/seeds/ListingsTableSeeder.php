<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

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
				'address' => $faker->address
			]);
		}
	}

}