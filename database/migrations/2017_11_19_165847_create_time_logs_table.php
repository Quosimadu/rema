<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('listing_id')->length(10)->unsigned();
            $table->integer('user_id')->length(10)->unsigned();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->text('comment')->nullable();
            $table->tinyInteger('is_paid')->default(0)->unsigned();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('changed_by')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('listing_id')
                ->references('id')->on('listings')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')->on('users')
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
        Schema::drop('time_logs');
    }
}
