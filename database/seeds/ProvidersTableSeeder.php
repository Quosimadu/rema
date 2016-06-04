<?php

use Illuminate\Database\Seeder;
use \App\Models\Provider;

class ProvidersTableSeeder extends Seeder {

    public function run()
    {

        factory(Provider::class, 40)->create();

    }

}

