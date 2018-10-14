<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExemptedTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exempted_times', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id');
            $table->string('from');
            $table->string('to');
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
        Schema::dropIfExists('exempted_times');
    }
}
