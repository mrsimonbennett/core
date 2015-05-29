<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContractTable extends Migration
{

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

                /**
                 * duration
                 */
                $table->timestamp('start')->nullable();
                $table->timestamp('end')->nullable();

                /**
                 * rent/deposit
                 */
                $table->float('rent')->nullable();
                $table->float('deposit')->nullable();
                $table->integer('rent_payable')->nullable();
                $table->timestamp('first_rent')->nullable();
                $table->boolean('fullrent_rent_collection', null)->nullable();
                $table->timestamp('deposit_due')->nullable();
                $table->boolean('fullrent_deposit', null)->nullable();


                /**
                 * Documents
                 */
                $table->boolean('require_id', null)->nullable();
                $table->boolean('require_earnings_proof', null)->nullable();

                /**
                 * Tenant
                 */
                $table->boolean('tenant_signed')->default(false);
                $table->text('tenant_signature')->nullable();

                /**
                 * Landlord
                 */
                $table->boolean('landlord_signed')->default(false);
                $table->text('landlord_signature')->nullable();

                $table->boolean('completed_dates')->default(false);
                $table->boolean('completed_rent')->default(false);
                $table->boolean('completed_documents')->default(false);
                $table->boolean('locked')->default(false);
                $table->boolean('waiting_on_landlord')->default(true);
                $table->boolean('waiting_on_tenant')->default(false);

                $table->string('status')->default('Draft');
                $table->boolean('active')->default(false);
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
