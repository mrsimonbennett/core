<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTenanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenancies',
            function (Blueprint $table) {
                $table->char('id', 36);
                $table->char('company_id', 36);
                $table->char('property_id', 36);
                $table->timestamp('tenancy_start');
                $table->timestamp('tenancy_end');
                $table->string('tenancy_rent_amount');
                $table->string('tenancy_rent_frequency');

                $table->timestamp('drafted_at');
                $table->string('status');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tenancies');
    }
}
