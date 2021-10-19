<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddressDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_detail', function (Blueprint $table) {
            $table->id('detail_id');
            $table->integer('province_id');
            $table->string('province_name');
            $table->integer('city_id');
            $table->string('city_name');
            $table->integer('district_id');
            $table->string('district_name');
            $table->integer('post_code');
            $table->text('detail');
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
        Schema::dropIfExists('address_detail');
    }
}