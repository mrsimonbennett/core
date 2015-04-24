<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\Schema::create('contracts',
            function (Blueprint $table) {
                $table->char('id', 36);
                $table->char('company_id', 36);
                $table->char('application_id', 36);
                $table->char('property_id', 36);

                $table->char('landlord_id', 36);

                $table->timestamp('created_at');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\Schema::drop('contracts');
    }

}
