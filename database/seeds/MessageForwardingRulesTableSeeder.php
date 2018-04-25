<?php

use Illuminate\Database\Seeder;
use App\Models\MessageForwardingRule;

class MessageForwardingRulesTableSeeder extends Seeder {

    public function run()
    {

        factory(MessageForwardingRule::class, 10)->create();

    }

}

