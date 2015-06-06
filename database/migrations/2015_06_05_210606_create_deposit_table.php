<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDepositTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\Schema::create('deposits',
            function (Blueprint $table) {
                $table->char('id', 36);
                $table->char('contract_id', 36);
                $table->char('tenant_id', 36);
                $table->float('deposit_amount');
                $table->timestamp('deposit_due');
                $table->boolean('fullrent_collection');
                $table->timestamp('setup_at');

            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Illuminate\Support\Facades\Schema::drop('deposits');
    }

}