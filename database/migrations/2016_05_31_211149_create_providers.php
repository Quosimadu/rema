<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProviders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('first_name', 128)->nullable()->index();
            $table->string('last_name', 128)->nullable()->index();
            $table->string('email', 128)->nullable();
            $table->string('mobile', 128)->nullable()->index();
            $table->text('comment')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('changed_by')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('providers');
    }
}
