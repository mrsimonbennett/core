<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTenancyTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fullrent.tenancy_tenants',
            function (Blueprint $table) {
                $table->char('tenant_id', 36);
                $table->char('tenancy_id', 36);
                $table->timestamp('invited_at');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fullrent.tenancy_tenants');
    }
}