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
            $table->string("orderid");
            $table->unsignedBigInteger("total_discount");
            $table->unsignedBigInteger("total_price");
            $table->unsignedBigInteger("tax")->nullable();
            $table->date("order_date");
            $table->unsignedInteger("total_order");
            $table->enum('status', array('new','shipped','packed','refunded','cancelled','delivered','out for delivery'))->default("new");
            $table->unsignedBigInteger("user_details_id");
            $table->foreign('user_details_id')->references('id')->on('user_details')->onDelete('restrict')->onUpdate('restrict');
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
        Schema::dropIfExists('orders');
    }
}
