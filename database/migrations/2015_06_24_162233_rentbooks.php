<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Rentbooks extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        \Illuminate\Support\Facades\Schema::create('rent_books',
            function (Blueprint $table) {
                $table->char('id', 36);
                $table->char('contract_id', 36);
                $table->char('tenant_id', 36);
                $table->float('rent_amount');
                $table->timestamp('opened_at');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Illuminate\Support\Facades\Schema::drop('rent_books');
    }

}
