<?php

use Illuminate\Database\Seeder;
use App\Models\Platform;

class PlatformsTableSeeder extends Seeder {

	public function run()
	{

		Platform::create([
			'id' => 1,
			'name' => 'airbnb'
		]);

	}

}