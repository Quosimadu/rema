<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
		$this->call(ListingsTableSeeder::class);
        $this->call(BookingsTableSeeder::class);
        $this->call(ProvidersTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
        $this->call(MessageTemplatesTableSeeder::class);
        $this->call(MessageSenderTableSeeder::class);
        $this->call(TimeLogTableSeeder::class);
    }
}
