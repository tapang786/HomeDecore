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
            $table->id();
            $table->text("pname")->nullable();
            $table->longText('categories')->nullable();
            $table->longText('thumbnails')->nullable();
            $table->string("sku_id")->nullable();
            $table->unsignedBigInteger("p_price")->nullable();
            $table->unsignedBigInteger("s_price")->nullable();
            $table->unsignedBigInteger("discount")->default("0");
            $table->text("p_s_description")->nullable();
            $table->text("feature")->nullable();
            $table->text("p_description")->nullable();
            $table->string("meta_title")->nullable();
            $table->string("meta_keyword")->nullable();
            $table->unsignedBigInteger("stock")->nullable();
            $table->unsignedBigInteger("stock_alert")->nullable();
            $table->tinyInteger("status")->default('1');
            $table->string("shipping")->default('free');
            $table->integer("shipping_charge")->nullable();
            $table->string('return_policy',20)->nullable();
            $table->text('tax_type')->nullable();
            $table->string('tax')->nullable();
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
        Schema::dropIfExists('products');
    }
}
