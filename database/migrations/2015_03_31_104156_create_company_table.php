<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompanyTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\Schema::create('companies',
            function (Blueprint $table) {
                $table->char('id', 36);
                $table->string('name');
                $table->string('domain');
                $table->string('gocardless_merchant')->nullalbe();
                $table->string('gocardless_token')->nullalbe();
                $table->timestamp('gocardless_setup_at')->nullalbe();
                $table->boolean('direct_debit_setup')->default(false);
                $table->timestamp('trail_expires')->default(\Carbon\Carbon::now())->nullable();
                $table->char('subscription_id', 36)->nullable();
                $table->string('subscription_plan')->default('trail');
                $table->string('subscription_plan_name')->default('Trail Plan');
                $table->timestamp('subscription_started_at')->nullable();

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
        \Illuminate\Support\Facades\Schema::drop('companies');
    }


}
