<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('shop_id');
            $table->string('user_id');
            $table->string('shop_name',50);
            $table->string('shop_address');
            $table->text('location');
            $table->string('shop_range',20);
            $table->string('phone_number',20);
            $table->string('identity_card');
            $table->string('tax');
            $table->string('background');
            $table->boolean('status');
            $table->timestamps();


            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
}
