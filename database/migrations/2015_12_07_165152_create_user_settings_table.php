<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTenancyTenantsTable
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class CreateTenancyTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->char('user_id', 36);

            foreach (array_keys(config('user.settings')) as $setting) {
                $table->string($setting);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_settings');
    }
}