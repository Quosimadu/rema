<?php

class BookingStatusesTableSeeder extends Seeder {

	public function run()
	{

		BookingStatus::create([
			'id' => 1,
			'name' => 'valid'
		]);
		BookingStatus::create([
			'id' => 2,
			'name' => 'cancelled'
		]);
		BookingStatus::create([
			'id' => 3,
			'name' => 'inquiry'
		]);

	}

}