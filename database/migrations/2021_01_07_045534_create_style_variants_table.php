<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStyleVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('style_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_gallary_image_id');
            $table->foreign('product_gallary_image_id')
            ->references('id')
            ->on('product_gallary_images')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->unsignedBigInteger('product_style_customization_id');
            $table->foreign('product_style_customization_id')
            ->references('id')
            ->on('product_style_customizations')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->softDeletes();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
            ->references('id')
            ->on('products')
            ->onDelete('cascade')
            ->onUpdate('cascade');
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
        Schema::dropIfExists('style_variants');
    }
}
