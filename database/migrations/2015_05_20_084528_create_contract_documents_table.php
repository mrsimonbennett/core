<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateContractDocumentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_documents',function(Blueprint $table)
        {
            $table->char('id',36)->index();
            $table->char('tenant_id',36)->index();
            $table->char('contract_id',36)->index();
            $table->string('type');
            $table->char('custom_document_id',36)->nullable();
            $table->timestamp('uploaded_at');
            $table->boolean('approved')->default(false);
            $table->boolean('reviewed')->default(false);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contract_documents');
    }

}
