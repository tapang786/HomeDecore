<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToProductGallaryImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_gallary_images', function (Blueprint $table) {
           $table->unsignedBigInteger('set_product_variant_id');
           $table->foreign('set_product_variant_id')->references('id')
           ->on('set_product_variants')
           ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_gallary_images', function (Blueprint $table) {
            $table->dropColumn('set_product_variant_id');
        });
    }
}
