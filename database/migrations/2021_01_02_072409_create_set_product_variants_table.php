<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('set_product_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('color_id');
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            $table->string('color_vary_price')->nullable();
            $table->longText('gallary_images')->nullable();
            $table->longText('neck_style')->nullable();
            $table->longText('sleeve_style')->nullable();
            $table->longText('length_style')->nullable();
            $table->longText('height')->nullable();
            $table->longText('matched_product')->nullable();
            $table->longText('product_size')->nullable();
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
        Schema::dropIfExists('set_product_variants');
    }
}
