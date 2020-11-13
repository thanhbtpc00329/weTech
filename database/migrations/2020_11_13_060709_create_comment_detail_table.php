<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('cmt_id')->unsigned();
            $table->string('shop_id');
            $table->text('content');
            $table->string('product_id');
            $table->boolean('status'); 
            $table->timestamps();


            $table->foreign('cmt_id')->references('id')->on('comments')->onDelete('cascade');
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
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
        Schema::dropIfExists('comment_detail');
    }
}
