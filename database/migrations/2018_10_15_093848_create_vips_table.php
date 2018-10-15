<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vip', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vip_id');
            $table->string('client_id');
            $table->string('phone');
            $table->string('vehicle_type');
            $table->string('time_duration');
            $table->string('price');
            $table->string('purpose');
            $table->string('car_reg');
            $table->string('qr_no')->nullable();
            $table->string('status')->nullable();
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('vips');
    }
}
