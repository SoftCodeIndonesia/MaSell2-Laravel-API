<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Product extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_product', function (Blueprint $table) {
            $table->id('product_id');
            $table->integer('store_master_id')->foreignId('storeId')->constrained('stores');
            $table->integer('store_id')->foreignId('storeId')->constrained('stores');
            $table->integer('original_price');
            $table->integer('price');
            $table->string('name');
            $table->string('description');
            $table->double('weight', 8, 2);
            $table->double('height', 8, 2);
            $table->double('length', 8, 2);
            $table->double('width', 8, 2);
            $table->integer('stock');
            $table->integer('pre_order_days');
            $table->integer('brand_name');
            $table->integer('is_danger');
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
        Schema::dropIfExists('master_product');
    }
}