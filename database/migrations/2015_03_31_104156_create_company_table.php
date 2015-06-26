<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		\Illuminate\Support\Facades\Schema::create('companies',function(Blueprint $table)
		{
			$table->char('id',36);
			$table->string('name');
			$table->string('domain');
            $table->string('gocardless_merchant')->nullalbe();
            $table->string('gocardless_token')->nullalbe();
            $table->timestamp('gocardless_setup_at')->nullalbe();
            $table->boolean('direct_debit_setup')->default(false);
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
		\Illuminate\Support\Facades\Schema::drop('companies');
	}


}
