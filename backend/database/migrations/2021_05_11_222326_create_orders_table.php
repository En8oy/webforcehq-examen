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
            $table->string("name");
            $table->unsignedBigInteger('product_id');
            $table->integer("quantity");
            $table->string("address");
            $table->string("country");
            $table->string("state");
            $table->string("email");
            $table->string("ccn");
            $table->string("ccd");
            $table->string("ccv");
            $table->double("total_sale_price");
            $table->enum("status", ["Preparing", "Sending", "Delivered"])->default("Preparing");
            $table->foreign('product_id')->references('id')->on('products')->onDelete("cascade");
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
