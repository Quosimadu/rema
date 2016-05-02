<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('roles', function(Blueprint $table)
		{
			$table->tinyInteger('id')->unsigned()->autoIncrement();
			$table->string('name', 20);
			$table->text('description');
			$table->tinyInteger('requires_super')->length(1)->default(1)->unsigned();
			$table->timestamps();
		});

		$roles = [
			['id' => 1, 'name' => 'admin', 'description' => 'system configuration'],
			['id' => 2, 'name' => 'support', 'description' => 'can see and do all, system support'],
			['id' => 3, 'name' => 'owner', 'description' => 'listing owners','requires_super' => 0],
			['id' => 4, 'name' => 'trustee', 'description' => 'can see all but not set things','requires_super' => 0],
			['id' => 5, 'name' => 'accountant', 'description' => 'accounting related reports','requires_super' => 0],
			['id' => 6, 'name' => 'service', 'description' => 'bookings without pricing','requires_super' => 0]
		];

		DB::table('roles')->insert($roles);

		/*Schema::create('listing_role_users', function(Blueprint $table)
		{
			$table->integer('listing_id')->unsigned();
			$table->foreign('listing_id')
				->references('id')->on('listings')
				->onDelete('cascade');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')
				->references('id')->on('users')
				->onDelete('cascade');
			$table->integer('role_id')->unsigned();
			$table->foreign('role_id')
				->references('id')->on('roles')
				->onDelete('cascade');
			$table->integer('created_by')->unsigned();
			$table->foreign('created_by')
				->references('id')->on('users')
				->onDelete('cascade');
			$table->timestamps();
		});*/
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('roles');
	}

}
