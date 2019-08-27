<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockReturnDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_return_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('return_id')->unsigned();
            $table->foreign('return_id')->references('id')->on('stock_return')->onDelete('cascade');
            $table->integer('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('products')->onDelete('cascade');
            $table->double('qty');
            $table->double('selling_price');
            $table->double('tax_val')->nullable();
            $table->string('tax_per', 10)->nullable();
            $table->double('discount')->nullable();
            $table->double('sub_total');
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
        Schema::dropIfExists('stock_return_details');
    }
}
