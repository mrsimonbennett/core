<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Rentbooksrent extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\Schema::create('rent_book_rent',
            function (Blueprint $table) {
                $table->char('id',36);
                $table->char('rent_book_id', 36);
                $table->string('status');
                $table->timestamp('due');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Illuminate\Support\Facades\Schema::drop('rent_book_rent');
    }

}
