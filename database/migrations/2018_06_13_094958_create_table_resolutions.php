<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableResolutions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resolutions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('booking_id')->length(10)->unsigned()->nullable();
            $table->date('date')->nullable();
            $table->string('code', 50)->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('changed_by')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('booking_id')
                ->references('id')->on('bookings')
                ->onDelete('cascade');
            $table->foreign('created_by')
                ->references('id')->on('users')
                ->onDelete('set null');
            $table->foreign('changed_by')
                ->references('id')->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('resolutions');
    }
}
