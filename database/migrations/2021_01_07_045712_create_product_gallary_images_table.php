<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductGallaryImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_gallary_images', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
            ->references('id')
            ->on('products')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->unsignedBigInteger('color_id');
            $table->foreign('color_id')
            ->references('id')
            ->on('colors')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('product_gallary_images');
    }
}
