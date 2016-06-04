<?php

use Illuminate\Database\Seeder;
use App\Models\Listing;


class ListingsTableSeeder extends Seeder {

	public function run()
	{

		factory(Listing::class, 16)->create();

	}

}