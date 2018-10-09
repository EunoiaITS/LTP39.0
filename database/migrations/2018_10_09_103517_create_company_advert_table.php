<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyAdvertTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_advert', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('advert_id');
            $table->integer('client_id');
            $table->string('client_name');
            $table->string('advert_text');
            $table->string('advert_image');
            $table->enum('advert_status',array('active','inactive'));
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
        Schema::dropIfExists('company_advert');
    }
}
