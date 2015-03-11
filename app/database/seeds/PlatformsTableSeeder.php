<?php

class PlatformsTableSeeder extends Seeder {

	public function run()
	{

		Platform::create([
			'id' => 1,
			'name' => 'airbnb'
		]);

	}

}