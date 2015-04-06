<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateApplicationsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\Schema::create('applications',
            function (Blueprint $table) {
                $table->char('id', 36);
                $table->char('applicant_id', 36);
                $table->char('property_id', 36);
                $table->string('about_description')->nullable();
				$table->string('date_of_birth')->nullable();
				$table->string('phone_number')->nullable();
				$table->timestamp('started_at');
			});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\Schema::drop('applications');
    }
}
