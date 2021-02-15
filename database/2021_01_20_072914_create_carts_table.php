<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
         
            $table->unsignedBigInteger("product_id");
            $table->foreign('product_id')->references('id')->on("products")
            ->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger("color_id");
            $table->foreign('color_id')->references('id')->on('colors')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->enum("size_type",['standard','custom']);
            $table->string('height');
            $table->longText('size');
            $table->integer('sleeve_id')->nullable();
            $table->integer('bottom_id')->nullable();
            $table->integer('neck_id')->nullable();
            $table->integer("quantity")->nullable();
            $table->longText('optional_style')->nullable();
            $table->string("sku_id")->nullable();
            $table->integer("user_id");
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('carts');
    }
}
