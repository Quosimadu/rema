<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageSenders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_senders', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('number', 128);
            $table->string('provider', 50);
            $table->softDeletes();
            $table->integer('created_by')->nullable();
            $table->integer('changed_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('message_senders');
    }
}
