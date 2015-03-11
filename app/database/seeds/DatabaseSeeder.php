<?php


class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('ListingsTableSeeder');
		$this->call('BookingStatusesTableSeeder');
		$this->call('PlatformsTableSeeder');
		$this->call('BookingsTableSeeder');
	}

}
