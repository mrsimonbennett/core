<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RentBookRentHistory extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('rent_book_rent_history',
            function (Blueprint $table) {
                $table->char('rent_book_rent_id', 36);
                $table->string('status');
                $table->timestamp('happened_at');
                $table->string('title');
                $table->string('description');

            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('rent_book_rent_history');
	}

}
