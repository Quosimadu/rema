<?php

use Illuminate\Database\Seeder;
use \App\Models\Message;

class MessagesTableSeeder extends Seeder {

    public function run()
    {

        factory(Message::class, 30)->create();

    }

}

