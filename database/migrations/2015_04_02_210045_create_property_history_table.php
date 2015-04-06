<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		\Illuminate\Support\Facades\Schema::create('property_history',
			function (Blueprint $table) {
				$table->char('id', 36);
				$table->char('property_id', 36);
				$table->string('event_name');
				$table->timestamp('event_happened');
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		\Illuminate\Support\Facades\Schema::drop('property_history');
	}

}
