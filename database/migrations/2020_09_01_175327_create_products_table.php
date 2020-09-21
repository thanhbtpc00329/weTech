<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('product_id')->primary();
            $table->string('product_name');
            $table->string('brand');
            $table->integer('cate_id')->length(10)->unsigned();
            $table->text('introduction');
            $table->text('description');
            $table->text('tag')->nullable();
            $table->integer('shop_id')->length(10)->unsigned();
            $table->string('status',50);
            $table->timestamps();

            
            $table->foreign('cate_id')->references('cate_id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
}
