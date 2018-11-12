<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVIPRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vip_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vipId')->nullable();
            $table->integer('client_id');
            $table->string('name');
            $table->integer('vehicle_type');
            $table->string('phone')->nullable();
            $table->string('car_reg');
            $table->string('purpose')->nullable();
            $table->string('price')->nullable();
            $table->string('time_duration')->nullable();
            $table->string('status')->nullable();
            $table->string('remark')->nullable();
            $table->integer('requested_by')->nullable();
            $table->integer('approved_by')->nullable();
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
        Schema::dropIfExists('vip_requests');
    }
}
