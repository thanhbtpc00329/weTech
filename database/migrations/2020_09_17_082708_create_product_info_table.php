<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->length(10)->unsigned();
            $table->string('origin');
            $table->string('accessorry');
            $table->string('dimention');
            $table->string('weight');
            $table->string('system');
            $table->string('material');

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
        Schema::dropIfExists('product_info');
    }
}
