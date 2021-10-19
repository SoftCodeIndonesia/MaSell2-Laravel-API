<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Address extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->unsignedBigInteger('store_id')->foreignId('storeId')->constrained('stores');
            $table->unsignedBigInteger('detail_id')->foreignId('detail_id')->constrained('address_detail');
            $table->timestamps();
            // $table->foreign('store_id')->references('storeId')->on('stores');
            // $table->foreign('detail_id')->references('detail_id')->on('address_detail');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address');
    }
}