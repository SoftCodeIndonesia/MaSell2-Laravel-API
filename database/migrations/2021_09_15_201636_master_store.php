<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MasterStore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_stores', function (Blueprint $table) {
            $table->id('store_master_id');
            $table->string('name');
            $table->string('url_store');
            $table->unsignedBigInteger('sellerId')->foreignId('sellerId')->constrained('seller');
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
        Schema::dropIfExists('master_stores');
    }
}