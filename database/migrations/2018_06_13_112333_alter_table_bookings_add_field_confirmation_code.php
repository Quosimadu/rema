<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableBookingsAddFieldConfirmationCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('confirmation_code', 50)->nullable()->after('id');
            $table->tinyInteger('nights')->nullable()->after('inquiry_date');
            $table->unsignedInteger('listing_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['confirmation_code', 'nights']);
            $table->unsignedInteger('listing_id')->change();
        });
    }
}
