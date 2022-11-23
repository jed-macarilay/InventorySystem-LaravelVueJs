<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_item', function (Blueprint $table) {
            $table->id();
            $table->string('ref');
            $table->integer('quantity');
            $table->float('price');
            $table->float('total');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('inventories');
            $table->unsignedBigInteger('shipping_id');
            $table->foreign('shipping_id')->references('id')->on('shippings');
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
        Schema::dropIfExists('shipping_item');
    }
}
