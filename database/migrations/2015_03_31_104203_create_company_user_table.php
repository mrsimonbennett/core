<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		\Illuminate\Support\Facades\Schema::create('company_users',function(Blueprint $table)
		{
			$table->char('user_id',36)->index();
			$table->char('company_id',36)->index();
			$table->string('role');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		\Illuminate\Support\Facades\Schema::drop('company_users');
	}
}
