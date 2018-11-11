<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParkingRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parking_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id');
            $table->string('parking_rate_id');
            $table->integer('vehicle_id');
            $table->string('base_hour');
            $table->string('base_rate');
            $table->string('sub_rate');
            $table->integer('exmin_id')->nullable();
            $table->integer('exhr_id')->nullable();
            $table->string('created_by')->nullable();
            $table->string('modified_by')->nullable();
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
        Schema::dropIfExists('parking_rates');
    }
}
