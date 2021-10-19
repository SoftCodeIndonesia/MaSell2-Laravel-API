<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CategoryVarian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_varian', function (Blueprint $table) {
            $table->id('category_varian_id');
            $table->unsignedBigInteger('product_id')->foreignId('product_id')->constrained('master_product');
            $table->string('name');
            $table->timestamps();

            // $table->foreign('product_id')->references('product_id')->on('master_product');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_varian');
    }
}