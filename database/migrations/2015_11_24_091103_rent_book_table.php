<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RentBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenancy_rent_book_payments',
            function (Blueprint $table) {
                $table->char('id', 36);
                $table->char('tenancy_id', 36);
                $table->timestamp('payment_due');
                $table->string('payment_amount');
                $table->timestamp('deleted_at')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tenancy_rent_book_payments');
    }
}
