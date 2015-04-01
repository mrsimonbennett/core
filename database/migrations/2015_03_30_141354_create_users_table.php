<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		\Illuminate\Support\Facades\Schema::create('users',function(Blueprint $table)
		{
			$table->char('id',36);
			$table->string('legal_name');
			$table->string('known_as');
			$table->string('email');
			$table->string('password');
			$table->timestamps();
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		\Illuminate\Support\Facades\Schema::drop('users');
	}

}
