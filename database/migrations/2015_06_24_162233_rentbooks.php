<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Rentbooks extends Migration
{

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
                $table->boolean('setup')->default(false);
                $table->string('pre_auth_id');
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
