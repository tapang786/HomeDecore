<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSizeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_size_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_size_id');
            $table->foreign('product_size_id')->references('id')->on('product_sizes')->onDelete('cascade')->onUpdate('cascade');
            $table->string('varient_value');
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
        Schema::dropIfExists('product_size_values');
    }
}
