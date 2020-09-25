<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_detail', function (Blueprint $table) {
            $table->increments('cart_detail_id');
            $table->string('cart_id');
            $table->integer('prodetail_id')->length(10)->unsigned();
            $table->integer('cart_quantity');
            $table->integer('shop_id')->length(10)->unsigned();
            
            
            $table->timestamps();

            $table->foreign('cart_id')->references('cart_id')->on('carts')->onDelete('cascade');
            $table->foreign('prodetail_id')->references('prodetail_id')->on('product_detail')->onDelete('cascade');
            $table->foreign('shop_id')->references('shop_id')->on('shops')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_detail');
    }
}
