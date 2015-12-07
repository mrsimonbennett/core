<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePropertyImagesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\Schema::create('property_images',
            function (Blueprint $table) {
                $table->char('property_id', 36);
                $table->char('image_id', 36);

                $table->index('property_id');
                $table->index('image_id');

                $table->timestamp('attached_at');
                $table->softDeletes();
            });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\Schema::drop('property_images');
    }
}
