<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_detail', function (Blueprint $table) {
            $table->increments('prodetail_id'); 
            $table->integer('product_id')->length(10)->unsigned();
            $table->integer('price')->unsigned();
            $table->string('color')->nullable();
            $table->integer('quantity')->length(50)->unsigned();
            $table->integer('size')->length(50)->unsigned()->nullable();
            $table->boolean('status');
            $table->integer('discount_price')->unsigned()->nullable();
            $table->string('origin')->nullable();
            $table->string('accessorry')->nullable();
            $table->string('dimention')->nullable();
            $table->string('weight')->nullable();
            $table->string('system')->nullable();
            $table->string('material')->nullable();
            $table->string('screen_size')->nullable();
            $table->string('wattage')->nullable();
            $table->string('resolution')->nullable();
            $table->string('memory')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_detail');
    }
}
