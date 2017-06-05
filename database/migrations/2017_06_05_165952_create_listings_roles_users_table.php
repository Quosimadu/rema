<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingsRolesUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings_roles_users', function(Blueprint $table)
        {
            $table->integer('id')->unsigned()->autoIncrement();
            $table->integer('listing_id')->unsigned();
            $table->tinyInteger('role_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('changed_by')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('listing_id')
                ->references('id')->on('listings')
                ->onDelete('cascade');
            $table->foreign('role_id')
                ->references('id')->on('roles')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('listings_roles_users');
    }
}
