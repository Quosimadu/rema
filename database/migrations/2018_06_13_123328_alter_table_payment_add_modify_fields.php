<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablePaymentAddModifyFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedInteger('resolution_id')->nullable()->after('booking_id');
            $table->foreign('resolution_id')->references('id')->on('resolutions');
            $table->tinyInteger('type_id')->after('id');
            $table->string('internal_document_number', 100)->nullable()->after('resolution_id');
            $table->unsignedInteger('booking_id')->nullable()->change();
            $table->unsignedInteger('account_id')->nullable()->change();
            $table->decimal('amount', 10, 2)->after('resolution_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['resolution_id']);
            $table->dropColumn(['resolution_id', 'type_id', 'internal_document_number', 'amount']);
            $table->unsignedInteger('booking_id')->change();
            $table->unsignedInteger('account_id')->change();
        });
    }
}
