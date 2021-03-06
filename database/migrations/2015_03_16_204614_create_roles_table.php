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
			$table->string('name', 20)->index();
			$table->text('description');
			$table->tinyInteger('requires_super')->length(1)->default(1)->unsigned();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('changed_by')->unsigned()->nullable();
			$table->timestamps();
		});

		$roles = [
			['id' => 1, 'name' => 'admin', 'description' => 'system configuration','requires_super' => 1],
			['id' => 2, 'name' => 'support', 'description' => 'can see and do all, system support','requires_super' => 1],
			['id' => 3, 'name' => 'owner', 'description' => 'listing owners','requires_super' => 0],
			['id' => 4, 'name' => 'trustee', 'description' => 'can see all but not set things','requires_super' => 0],
			['id' => 5, 'name' => 'accountant', 'description' => 'accounting related reports','requires_super' => 0],
			['id' => 6, 'name' => 'service', 'description' => 'bookings without pricing','requires_super' => 0]
		];

		DB::table('roles')->insert($roles);

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
