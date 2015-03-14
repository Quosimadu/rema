<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBookingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bookings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('listing_id')->length(10)->unsigned();
			$table->tinyInteger('people')->length(4);
			$table->string('guest_name', 128);
			$table->string('guest_country', 2)->nullable();
			$table->string('guest_email', 128)->nullable();
			$table->string('guest_phone', 128)->nullable();
			$table->string('guest_language', 2)->nullable();
			$table->integer('platform_id')->length(10)->default(1)->unsigned();
			$table->tinyInteger('booking_status_id')->default(1)->unsigned();
			$table->date('inquiry_date')->nullable();
			$table->date('arrival_date');
			$table->time('arrival_time')->nullable();
			$table->date('departure_date')->nullable();
			$table->time('departure_time')->nullable();
			$table->string('airbnb_conversation_id', 20)->nullable();
			$table->text('comment')->nullable();
			$table->timestamps();
			$table->users();
			$table->foreign('listing_id')
				->references('id')->on('listings')
				->onDelete('cascade');
			$table->foreign('platform_id')
				->references('id')->on('platforms')
				->onDelete('cascade');
			$table->foreign('booking_status_id')
				->references('id')->on('booking_statuses')
				->onDelete('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

		Schema::drop('bookings');
	}

}
