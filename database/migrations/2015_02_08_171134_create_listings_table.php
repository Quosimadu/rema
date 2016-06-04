<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateListingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('listings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 128);
			$table->tinyInteger('guests')->length(4);
			$table->tinyInteger('beds')->length(4);
			$table->text('address');
            $table->time('checkin_time')->nullable();
            $table->time('checkout_time')->nullable();
			$table->integer('created_by')->nullable();
			$table->integer('changed_by')->nullable();
			$table->timestamps();
			$table->string('airbnb_listing_id', 20)->nullable();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('listings');
	}

}
