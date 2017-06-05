<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use App\Models\BookingStatus;

class CreateBookingStatusesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('booking_statuses', function(Blueprint $table)
		{
			$table->tinyInteger('id')->unsigned()->autoIncrement();
			$table->string('name', 20);
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('changed_by')->unsigned()->nullable();
			$table->timestamps();
		});

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


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('booking_statuses');
	}

}
