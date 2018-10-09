<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyDeviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_device', function (Blueprint $table) {
            $table->increments('id');
            $table->string('device_id');
            $table->string('factory_id');
            $table->string('charger_id');
            $table->integer('client_id')->nullable();
            $table->string('created_by');
            $table->string('modified_by');
            $table->enum('status',array('assigned','unassigned'));
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
        Schema::dropIfExists('company_device');
    }
}
