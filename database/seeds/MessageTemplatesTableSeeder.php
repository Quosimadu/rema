<?php

use Illuminate\Database\Seeder;
use App\Models\MessageTemplate;


class MessageTemplatesTableSeeder extends Seeder {

	public function run()
	{
		factory(MessageTemplate::class, 15)->create();

	}

}