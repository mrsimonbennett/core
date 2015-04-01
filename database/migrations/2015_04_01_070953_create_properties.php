<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProperties extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\Schema::create('properties',
            function (Blueprint $table) {
                $table->char('id', 36);
                $table->string('address_firstline');
                $table->string('address_city');
                $table->string('address_county');
                $table->string('address_country');
                $table->string('address_postcode');

                $table->char('company_id', 36);
                $table->char('landlord_id', 36);

                $table->integer('bedrooms');
                $table->integer('bathrooms');
                $table->integer('parking');

                $table->string('pets');

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
        \Illuminate\Support\Facades\Schema::drop('properties');
    }
}
