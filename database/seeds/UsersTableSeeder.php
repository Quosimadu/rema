<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder {

    public function run()
    {
        Eloquent::unguard();

        factory(User::class,1)->create(['email' => 'quosimadu@example.org','password' => bcrypt('test')]);
        factory(User::class, 3)->create();

    }

}

