<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckInOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_in_out', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_id');
            $table->string('ticket_id');
            $table->string('receipt_id');
            $table->string('vehicle_type');
            $table->string('vehicle_reg');
            $table->string('fair')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('check_in_out');
    }
}
