<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyBillingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_billing', function (Blueprint $table) {
            $table->increments('id');
            $table->string('billing_id');
            $table->integer('client_id');
            $table->string('billing_term');
            $table->string('billing_amount');
            $table->dateTime('bill_start_date');
            $table->string('auto_renew');
            $table->string('created_by');
            $table->string('modified_by');
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
        Schema::dropIfExists('company_billing');
    }
}
