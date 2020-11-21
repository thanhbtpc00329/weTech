<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('order_address');
            $table->integer('shipping');
            $table->string('user_range')->nullable();
            $table->integer('total')->length(10)->unsigned();
            $table->integer('shop_id')->length(10)->unsigned();
            $table->integer('shipper_deliver')->length(10)->unsigned()->nullable();
            $table->integer('shipper_receive')->length(10)->unsigned()->nullable();
            $table->string('status');
            $table->text('order_detail');
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('shop_id')->references('shop_id')->on('shops')->onDelete('cascade');
            $table->foreign('shipper_deliver')->references('shipper_id')->on('shippers')->onDelete('cascade');
            $table->foreign('shipper_receive')->references('shipper_id')->on('shippers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
