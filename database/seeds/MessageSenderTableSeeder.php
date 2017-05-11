<?php

use Illuminate\Database\Seeder;
use App\Models\MessageSender;

class MessageSenderTableSeeder extends Seeder {

    public function run()
    {

        factory(MessageSender::class, 3)->create();

    }

}

